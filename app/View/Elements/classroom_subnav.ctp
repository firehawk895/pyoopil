<div class="clearfix">
    <ul class="left-subnav clearfix">
        <li><a href="classroom.htm" class="active">My Classrooms</a>
        </li>
        <li><a href="staff-room.htm">Staffroom</a>
        </li>
        <li><a href="classroom-archived.htm">Archived Classrooms</a>
        </li>
        <li><div class="loader"><img src="images/loading/ajax-loader.gif" alt="loading"></div></li>
    </ul>
    <a href="javascript:void(0)" class="sub-btn dialogbox" title="create-assign">Create New Classroom</a>
    <!--popup-->
    <div id="create-assign" class="create-popup doc-popup">
        <div class="pop-wind clearfix">
            <div class="pop-head clearfix">
                <span>Create Classroom</span>
                <a class="close-link" href="#">
                    <span class="icon-cross"></span></a>
            </div>
            <div class="pop-content clearfix">
                <form class="form-data create-popup">
                    <div class="left-pop">
                        <label>Name of the classrom</label>
                        <input type="text" class="pop-input" />
                        <label>University Association</label>
                        <select class="chosen-select select_option">
                            <option>University Association 1</option>
                            <option>University Association 2</option>
                            <option>University Association 3</option>
                            <option>University Association 4</option>
                        </select>
                        <label>Department</label>
                        <select class="chosen-select select_option">
                            <option>Department 1</option>
                            <option>Department 2</option>
                            <option>Department 3</option>
                            <option>Department 4</option>
                        </select>
                        <label>Year</label>
                        <div class="year-dd">
                            <select class="chosen-select">
                                <option>2010</option>
                                <option>2011</option>
                                <option>2012</option>
                                <option>2013</option>
                            </select>
                        </div>
                        <div class="check-btn">
                            <input id="others" type="checkbox" name="others" value="others">
                            <label for="others" class="radio-lbl">Others</label>
                        </div>
                        <label>Duration of the course</label>
                        <div class="calender create-date">
                            <input type="text" class="pop-dura date_popup" />
                        </div>
                        <div class="calender create-date">
                            <input type="text" class="pop-dura date_popup" />
                        </div>
                        <label>Semester</label>
                        <select class="chosen-select select_option">
                            <option>Semester 1</option>
                            <option>Semester 2</option>
                            <option>Semester 3</option>
                            <option>Semester 4</option>
                        </select>
                    </div>
                    <div class="right-pop">
                        <label>Course Type</label>
                        <div class="radio-btn">
                            <input id="Public" type="radio" name="course" value="Public">
                            <label for="Public" class="radio-lbl">Public</label>
                            <input id="Private" type="radio" name="course" value="Private">
                            <label for="Private" class="radio-lbl">Private</label>
                        </div>
                        <label>Course Description</label>
                        <textarea class="pop-txtarea"></textarea>
                        <label>Degree</label>
                        <input type="text" class="pop-input" />
                        <label>You tube video link</label>
                        <input type="text" class="pop-input" />
                        <label>Minimum required attendance</label>
                        <input type="text" class="pop-dura" pattern="[0-9]{0,3}" title="Should be numbers.Max 3 numbers" />
                        % </div>
                    <div class="clear"></div>
                    <div class="submit-btn">
                        <input type="button" class="sub-btn" value="Create" id="quiz-link">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--quiz popup-->
    <div id="quizdialog" class="quizdia create-popup">
        <div class="pop-wind clearfix">
            <div class="pop-head clearfix">
                <span>Classroom Created</span>
                <a class="close-link" href="#">
                    <span class="icon-cross"></span></a>
            </div>
            <div class="pop-content">
                <div class="created-contt">
                    <p class="created-heading">Your Class ______has been successfully created.</p>
                    <p class="created-txt">Please find below the unique group password. You can distribute the password to your friends so that they can join the group. </p>
                    <p class="created-txt">An E-mail with the password has also been sent to you for your convenience.</p>
                    <p class="created-txt">Unique acess code: <span class="code-txt">AEW124Q</span>
                    </p>
                    <p class="created-txt">Now make your class more engaging with pyoopil. Kudos for setting up the class. Have a great session this semester with your students. Cheers!!</p>
                    <div class="pop-close">
                        <a href="classroom.htm" class="sub-btn">Take me to my classrooms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>