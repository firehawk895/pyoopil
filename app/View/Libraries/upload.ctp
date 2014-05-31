<form class="form-data">
    <div class="upload-form clearfix">
        <!-- form 1 -->
        <div id="form1">
            <p class="up-heading"> Step 1 of 2</p>
            <div class="select-topic">
                <a href="javascript:void(0)" class="sel-topic">Select Topic</a>
                <div class="seltop-dd">
                    <a href="javascript:void(0)" class="new-topic">Create New Topic</a>
                    <ul>
                        <li><a href="javascript:void(0)">Topic 1</a>
                        </li>
                        <li><a href="javascript:void(0)">Topic 2</a>
                        </li>
                        <li><a href="javascript:void(0)">Topic 3</a>
                        </li>
                        <li><a href="javascript:void(0)">Topic 4</a>
                        </li>
                    </ul>
                </div>
                <input type="text" class="pop-input" placeholder="Enter Topic Name" />
                <div class="nav-btn">
                    <input type="button" class="follow active goto2" value="Next">
                </div>
            </div>
        </div>
        <!-- form 2 -->
        <div id="form2">
            <p class="up-heading">Step 2 of 2</p>
            <div class="select-topic">
                <p class="sub-sel">Topic Name:<span> Topic 1</span></p>
                <div class="tabpages">
                    <ul class="upload-tab">
                        <li><a href="#file1" class="tab active">Upload file</a>
                        </li>
                        <li><a href="#link1" class="tab">Upload link</a>
                        </li>
                    </ul>
                    <div id="file1" class="tab-contt">
                        <p>Select file to upload</p>
                        <div class="upload-files">
                            <div class="add-upload clearfix">
                                <div class="custom-upload" id="test0">
                                    <input type="file" name="files[]">
                                    <div class="file-upload">
                                        <span class="file-txt">Select file</span>
                                        <input disabled="disabled" value="No File Chosen">
                                    </div>
                                    <div class="size-txt">(Max. 00 mb)</div>
                                </div>
                            </div>
                            <span class="add-more tooltip" title="Add File"></span>
                        </div>
                        <div class="error-txt">
                            <p>! File exceeded max. limit. </p>
                            <p>Select another file or reduce size and upload again</p>
                        </div>
                    </div>
                    <div id="link1" class="tab-contt">
                        <p>Paste link here</p>
                        <div class="upload-links">
                            <div class="add-links">
                                <input type="text" class="pop-input" placeholder="Upload links">
                            </div>
                        </div>
                        <span class="add-link tooltip" title="Add Link"></span>
                    </div>
                </div>
                <div class="nav-btn">
                    <input type="button" class="follow backto1" value="Oops !">
                    <input type="button" class="follow active" value="Save">
                </div>
            </div>
        </div>
    </div>
</form>