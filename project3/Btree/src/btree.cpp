/**
 * @author See Contributors.txt for code contributors and overview of BadgerDB.
 *
 * @section LICENSE
 * Copyright (c) 2012 Database Group, Computer Sciences Department, University of Wisconsin-Madison.
 */

#include "btree.h"
#include "filescan.h"
#include "exceptions/bad_index_info_exception.h"
#include "exceptions/bad_opcodes_exception.h"
#include "exceptions/bad_scanrange_exception.h"
#include "exceptions/no_such_key_found_exception.h"
#include "exceptions/scan_not_initialized_exception.h"
#include "exceptions/index_scan_completed_exception.h"
#include "exceptions/file_not_found_exception.h"
#include "exceptions/end_of_file_exception.h"


//#define DEBUG

namespace badgerdb
{

// -----------------------------------------------------------------------------
// BTreeIndex::BTreeIndex -- Constructor
// -----------------------------------------------------------------------------

BTreeIndex::BTreeIndex(const std::string & relationName,
		std::string & outIndexName,
		BufMgr *bufMgrIn,
		const int attrByteOffset,
		const Datatype attrType)
{
	// standard form for index file name
	std::ostringstream idxStr;
	idxStr << relationName << "." << attrByteOffset;
	outIndexName == idxStr.str();

	// check if the file exists
	if(BlobFile::exists(outIndexName))
	{
		BlobFile::open(outIndexName);
	}
	else
	{
		BlobFile::create(outIndexName);
	}

	// scanning the records
	RecordId scanRid;
	std::string recordStr;


	// iterate over each record in relationName
	FileScan fscan(relationName, bufMgrIn);

	while(true)
	{
		fscan.scanNext(scanRid);
		recordStr = fscan.getRecord();
		// insert the record to page being scanned
		currentPageData->insertRecord(recordStr);

	}
	
	


}


// -----------------------------------------------------------------------------
// BTreeIndex::~BTreeIndex -- destructor
// -----------------------------------------------------------------------------

BTreeIndex::~BTreeIndex()
{

	// iterate over all the pages
	for (int i=0; i < bufMgr->numBuf(); i++ )
	{
		auto descTable = bufMgr->getBufDescTable()[i];
		auto pageNo = descTable.getPageId();

		// if pinned, unpin it
		if (descTable.getPinCount() > 0)
		{
			bufMgr->unPinPage(file, pageNo, false);
		}
	}
	bufMgr->~BufMgr();

	// flush file
	bufMgr->flushFile(file);

	// delete index file object
	file->~File();
}

// -----------------------------------------------------------------------------
// BTreeIndex::insertEntry
// -----------------------------------------------------------------------------

const void BTreeIndex::insertEntry(const void *key, const RecordId rid) 
{
	
}

// -----------------------------------------------------------------------------
// BTreeIndex::startScan
// -----------------------------------------------------------------------------

const void BTreeIndex::startScan(const void* lowValParm,
				   const Operator lowOpParm,
				   const void* highValParm,
				   const Operator highOpParm)
{

}

// -----------------------------------------------------------------------------
// BTreeIndex::scanNext
// -----------------------------------------------------------------------------

const void BTreeIndex::scanNext(RecordId& outRid) 
{

}

// -----------------------------------------------------------------------------
// BTreeIndex::endScan
// -----------------------------------------------------------------------------
//
const void BTreeIndex::endScan() 
{

}

}
