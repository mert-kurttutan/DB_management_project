/**
 * @author See Contributors.txt for code contributors and overview of BadgerDB.
 *
 * @section LICENSE
 * Copyright (c) 2012 Database Group, Computer Sciences Department, University of Wisconsin-Madison.
 */

#include <memory>
#include <iostream>
#include "buffer.h"
#include "exceptions/buffer_exceeded_exception.h"
#include "exceptions/page_not_pinned_exception.h"
#include "exceptions/page_pinned_exception.h"
#include "exceptions/bad_buffer_exception.h"
#include "exceptions/hash_not_found_exception.h"

namespace badgerdb { 

BufMgr::BufMgr(std::uint32_t bufs)
	: numBufs(bufs) {
	bufDescTable = new BufDesc[bufs];

  for (FrameId i = 0; i < bufs; i++) 
  {
  	bufDescTable[i].frameNo = i;
  	bufDescTable[i].valid = false;
  }

  bufPool = new Page[bufs];

	int htsize = ((((int) (bufs * 1.2))*2)/2)+1;
  hashTable = new BufHashTbl (htsize);  // allocate the buffer hash table

  clockHand = bufs - 1;
}


BufMgr::~BufMgr() {

	for (FrameId i = 0; i < numBufs; i++)
	{
		// check if it is dirty page
		if(bufDescTable[i].dirty)
		{
			// write to the page it belongs to
			bufDescTable[i].file->writePage(bufPool[i]);
		}
	}

	// deallocate the buffer pool and buffer desc table
	delete[] bufPool ;
	delete[] bufDescTable;

	std::cout<< "Mert - Calling BufMgr Destructor\n";

}

void BufMgr::advanceClock()
{
	clockHand = (clockHand + 1 ) % numBufs;
}

void BufMgr::allocBuf(FrameId & frame) 
{
	// set the clockhand to input frame
	bool is_valid = true;
	bool is_pinned = true;
	int i;
	for(i=0; i < numBufs; advanceClock())
	{
		if (bufDescTable[clockHand].pinCnt != 0){
			i++;
		}
		
		if (!bufDescTable[clockHand].valid)
		{	
			//if it is valid go out of loop, see clock algorithm
			is_valid = false;
			break;
		}
		
		if(bufDescTable[clockHand].refbit)
		{
			//if refbit is set then go to feedback loop and set it to false
			bufDescTable[clockHand].refbit = false;
			continue;
		}

		// if it is not pinned go further,
		if(bufDescTable[clockHand].pinCnt == 0)	
		{
			is_pinned = false;
			break;
		}
	}

	// no need to check pin condition since it must be that pin condition is false 

	if (i == numBufs)
	{
		throw badgerdb::BufferExceededException();
	}

	// if it is valid, do a few steps, clock algorithm
	if (is_valid)
	{
		if(bufDescTable[clockHand].dirty)
		{
			//flush the page to disk
			bufDescTable[clockHand].file->writePage(bufPool[clockHand]);
		}

		// remove if the page exists in hash table, otherwise exception
		// this makes buffer frame available for usage

		try
		{
			hashTable->remove(bufDescTable[clockHand].file, bufDescTable[clockHand].pageNo);
		}
		catch(const std::exception& e)
		{}
	}

	// call set on the allocated frame
	frame = clockHand;
}

	
void BufMgr::readPage(File* file, const PageId pageNo, Page*& page)
{ 
	FrameId my_frame = 0;
	try
	{
		// use try since lookup throws exception if page not found in hash table
		hashTable->lookup(file, pageNo, my_frame);

		// when reading page set refbit and increase pinCount
		// this will imply that the frames will be passes in the next turn
		bufDescTable[my_frame].refbit = true;
		bufDescTable[my_frame].pinCnt++;
	}
	catch(const std::exception& e)
	{
		//if page is not found in the buffer, allocate new frame in the buffer
		allocBuf(my_frame);

		// read existing page from disk to buffer
		bufPool[my_frame] = file->readPage(pageNo);

		// set the info in hash table and description table
		hashTable->insert(file, pageNo,my_frame);
		bufDescTable[my_frame].Set(file, pageNo);
		
	}

	page = &bufPool[my_frame];
	
	
}


void BufMgr::unPinPage(File* file, const PageId pageNo, const bool dirty) 
{
	bool excp_cond = false;

	FrameId my_frame = 0;
	try{
		hashTable->lookup(file, pageNo, my_frame);
	}
	catch(const std::exception& e){
		return;
	}

	
	if (bufDescTable[my_frame].pinCnt == 0)
	{
		throw badgerdb::PageNotPinnedException(file->filename(), pageNo, my_frame);
	}

	// unpin if page is found
	bufDescTable[my_frame].pinCnt--;

	if (dirty)
		bufDescTable[my_frame].dirty = dirty;
	
}

void BufMgr::flushFile(File* file) 
{
	// flush file (write to disk) dirty files by iterating hash table
	for (FrameId idx=0; idx < numBufs; idx++)
	{
		if(bufDescTable[idx].file == file)
		{
			// throws error if pinned
			if(bufDescTable[idx].pinCnt != 0)
			{
				throw badgerdb::PagePinnedException(file->filename(), bufDescTable[idx].pageNo, bufDescTable[idx].frameNo);
			}
			// error if not valid

			if (!bufDescTable[idx].valid)
			{
				throw badgerdb::BadBufferException(idx, bufDescTable[idx].dirty, bufDescTable[idx].valid, bufDescTable[idx].refbit);
			}

			if (bufDescTable[idx].dirty)
			{
				// if dirty write to disk and render it not dirty 
				file->writePage(bufPool[idx]);
				bufDescTable[idx].dirty = false;
			}

			// remove entries from hash table and description table
			hashTable->remove(file, bufDescTable[idx].pageNo);
			bufDescTable[idx].Clear();

			
		}
	}
}

void BufMgr::allocPage(File* file, PageId &pageNo, Page*& page) 
{

	FrameId my_frame = 0;
	// allocate from buffer pool
	allocBuf(my_frame);

	// allocate page and return by reference
	bufPool[my_frame] = file->allocatePage();
	page = &bufPool[my_frame];
	pageNo = bufPool[my_frame].page_number();

	// update hash and description table
	hashTable->insert(file, pageNo, my_frame);
	bufDescTable[my_frame].Set(file, pageNo);

}

void BufMgr::disposePage(File* file, const PageId PageNo)
{
    FrameId my_frame = 0;

	try
	{
		// catch the exception to make sure
		// page is allocated a frame in the buffer
		hashTable->lookup(file, PageNo, my_frame);

		//free from memory
		bufDescTable[my_frame].Clear();

		// delete from hash table
		hashTable->remove(file, PageNo);
		file->deletePage(PageNo);
		
	}
	catch(const std::exception& e)
	{
	}
	
	
}

void BufMgr::printSelf(void) 
{
  BufDesc* tmpbuf;
	int validFrames = 0;
  
  for (std::uint32_t i = 0; i < numBufs; i++)
	{
  	tmpbuf = &(bufDescTable[i]);
		std::cout << "FrameNo:" << i << " ";
		tmpbuf->Print();

  	if (tmpbuf->valid == true)
    	validFrames++;
  }

	std::cout << "Total Number of Valid Frames:" << validFrames << "\n";
}

}
