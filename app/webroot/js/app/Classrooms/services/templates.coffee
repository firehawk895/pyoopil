App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->


	class Templates

		constructor : ->

			@setTemplates()

		setTemplates : ->

			@templates = {
				'classroomTile' : '<li><a href="{{ Classroom.Url }}">{{#if UsersClassroom.is_restricted}}<div class="lock-state"><p>! You do not have access to this class. Please contact the owner</p></div>{{/if}}{{#if UsersClassroom.is_teaching }}<div class="class-head">My Class</div>{{/if}}{{#if Classroom.is_private}}<img src="images/lock_icon.png" class="lock">{{/if}}<div class="doc-top"><p class="subject">{{ Classroom.title }}</p><div>by</div><div><span class="online"></span>{{ Classroom.Educator }}</div><div class="totalstudent">( {{Classroom.users_classroom_count}} Students)</div></div>{{#if Classroom.Campus.name}}<p class="doc-end"> {{Classroom.Campus.name}} </p>{{/if}}</a></li>',
				'quizTmpl' : '<div class="pop-wind clearfix">
					            <div class="pop-head clearfix">
					              <span>Classroom Created</span>
					              <a class="close-link" href="#">
					              <span class="icon-cross"></span></a>
					            </div>
					            <div class="pop-content">
					              <div class="created-contt">
					                <p class="created-heading">Your Class {{ Classroom.name }} has been successfully created.</p>
					                {{#if Classroom.is_private}}
					                <p class="created-txt">Please find below the unique group password. You can distribute the password to your friends so that they can join the group. </p>
					                <p class="created-txt">An E-mail with the password has also been sent to you for your convenience.</p>
					                <p class="created-txt">Unique acess code: <span class="code-txt">{{Classroom.access_code }}</span>
					                </p>
					                {{/if}}
					                <p class="created-txt">Now make your class more engaging with pyoopil. Kudos for setting up the class. Have a great session this semester with your students. Cheers!!</p>
					                <div class="pop-close">
					                  <a href="classroom.htm" class="sub-btn">Take me to my classrooms</a>
					                </div>
					              </div>
					            </div>
					          </div>',
				"discussionTmpl" : '<ul class="disc-list discussion discussion_{{Discussion.id}}" data-discussion-id="{{ Discussion.id }}">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/follow1.jpg" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon quest-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{ Discussion.topic }}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{ AppUser.fname }} {{ AppUser.lname }}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip"><img src="http://localhost/PDD/pyoopil/images/disc-share.png"></a>
						                  <a href="javascript:void(0)" class="vl-t tooltip"><img src="http://localhost/PDD/pyoopil/images/disc-close.png"></a>
						                  <a class="fold-icon tooltip" href="javascript:void(0)"></a>
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt"> {{ Discussion.body }} </p>
						                <div class="arrbox-footer gamification clearfix">
							                {{#if Discussion}}
												<div class="f-left prs-sp">
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
													<div class="clk-tt" style="display: none;">
													  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
													    <li><a href="javascript:void(0)" data-praise-type="eh"><span>EH</span>Engagement</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
													    </li>
													    <li class="lastli"><a href="javascript:void(0)" data-praise-type="en"><span>EN</span> Endorsement</a>
													    </li>
													  </ul>
													</div>
												</div>
											{{/if}}
											{{#if Discussion.showGamification}}
												<div class="f-right">
													{{displayGamification this}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
						            {{#if Reply}}
							            <div class="bor-rep"><a href="javascript:void(0)" class="view-more">View next 5 answers <img src="http://localhost/PDD/pyoopil/images/view-all.png"></a>
				                        </div>
			                        {{/if}}
			                        {{#unless Reply}}
			                        	<div class="bor-rep"><a href="javascript:void(0)" class="view-more">Be the first to Reply</a>
				                        </div>
				                    {{/unless}}
						          </li>
						          <ul class="replies">
  					            	{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/chat2.png" class="disc-img"></a>
								              </div>
								              <div class="arrow_box">
								                <div class="name-left">
								                  <p class="tname"><a href="javascript:void(0)">{{AppUser.fname}} {{AppUser.lname}}</a></p>
								                  <p class="tby">{{ created }}</p>
								                </div>
								                <div class="icon-right">
								                  <span class="dd-block">
								                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
								                  <div class="arr-dd" style="display: none;">
								                    <ul>
								                      <li><a href="javascript:void(0)">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer gamification clearfix">

								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
					            	<form method="post" class="reply">
						            	<input class="add-ans" name="comment" type="text" placeholder="Add your answer...">
						            	<input type="hidden" name="discussion_id" value="{{Discussion.id}}">
					            	</form>
						        </ul>
					          </ul>',
				'pollTmpl' : '<ul class="disc-list">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/follow4.jpg" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{Discussion.topic}}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{AppUser.fname}} {{AppUser.lname}}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip"><img src="http://localhost/PDD/pyoopil/images/disc-share.png"></a>
						                  <span class="dd-block abuse-dd"><a href="javascript:void(0)" class="dd-icon dd-click tooltip"></a>
						                  <div class="arr-dd" style="display: none;">
						                    <ul>
						                      <li class="lastli"><a href="javascript:void(0)">Report Abuse</a>
						                      </li>
						                    </ul>
						                  </div>
						                  </span>
						                  <a class="fold-icon tooltip" href="javascript:void(0)"></a>
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt">{{ Discussion.body }}</p>
						                <div class="clearfix">
						                    <div class="poll-left">
						                    	{{#Poll Pollchoice}}
					                        	{{/Poll}}
					                        </div>
						               		<div class="poll-right">
						                   		<div id="chart_div2" style="position: relative;">
						                   		</div>
						                   	</div>
						                </div>
						                
						                <div class="arrbox-footer clearfix">
						                  <div class="f-left prs-sp">
						                    <a href="javascript:void(0)" class="icon-title"><span class="praise-icon">{{Discussion.display_praise}}</span>Praise</a>
						                    <div class="clk-tt" style="display: none;">
						                      <ul>
						                        <li><a href="javascript:void(0)"><span>EH</span>Engagement</a>
						                        </li>
						                        <li><a href="javascript:void(0)"><span>IN</span>Intelligence</a>
						                        </li>
						                        <li><a href="javascript:void(0)"><span>CU</span>Curiosity</a>
						                        </li>
						                        <li><a href="javascript:void(0)"><span>CO</span>Contribution</a>
						                        </li>
						                        <li class="lastli"><a href="javascript:void(0)"><span>EN</span>Endorsement</a>
						                        </li>
						                      </ul>
						                    </div>
						                  </div>
						                  <div class="f-right">
						                    <div class="enga">
						                      <a href="javascript:void(0)" class="msg-link point-icon">EN</a>
						                      <div class="enga-tooltip" style="display: none;">
						                        <div class="enga-list">
						                          <ul>
						                            <li><p class="tt-name">Amar Verma</p></li>
						                            <li><p class="tt-name">Akriti Singh</p></li>
						                            <li><p class="tt-name">Deepti Singh</p></li>
						                          </ul>
						                        </div>
						                      </div>
						                      <span class="icon-title">17</span>
						                    </div>
						                  </div>
						                </div>
						              </div>
						            </div>
						            <div class="bor-rep"><a href="javascript:void(0)" class="view-more">View all 5 answers <img src="http://localhost/PDD/pyoopil/images/view-all.png"></a>
						            </div>
						          </li>
						          					            	{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/chat2.png" class="disc-img"></a>
								              </div>
								              <div class="arrow_box">
								                <div class="name-left">
								                  <p class="tname"><a href="javascript:void(0)">{{AppUser.fname}} {{AppUser.lname}}</a></p>
								                  <p class="tby">Today at 11:20 am</p>
								                </div>
								                <div class="icon-right">
								                  <span class="dd-block">
								                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
								                  <div class="arr-dd" style="display: none;">
								                    <ul>
								                      <li><a href="javascript:void(0)">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer clearfix">
								                  <div class="f-left prs-sp">
								                    <a href="javascript:void(0)" class="icon-title"><span class="praise-icon">61</span>Praise</a>
								                    <div class="clk-tt" style="display: none;">
								                      <ul data-type="Reply" data-discussion-id="{{ ../Discussion.id }}" class="praise" data-reply-id={{ id }}>
								                        <li><a href="javascript:void(0)"><span>EH</span>Engagement</a>
								                        </li>
								                        <li><a href="javascript:void(0)"><span>IN</span>Intelligence</a>
								                        </li>
								                        <li><a href="javascript:void(0)"><span>CU</span>Curiosity</a>
								                        </li>
								                        <li><a href="javascript:void(0)"><span>CO</span>Contribution</a>
								                        </li>
								                        <li class="lastli"><a href="javascript:void(0)"><span>EN</span>Endorsement</a>
								                        </li>
								                      </ul>
								                    </div>
								                  </div>
								                  <div class="f-right">
								                  	{{#if showGamification}}
								                    <div class="enga">
								                      <a href="javascript:void(0)" class="msg-link point-icon">EN</a>
								                      <div class="enga-tooltip" style="display: none;">
								                        <div class="enga-list">
								                          <ul>
								                            <li><p class="tt-name">Amar Verma</p></li>
								                          </ul>
								                        </div>
								                      </div>
								                      <span class="icon-title">17</span>
								                    </div>
								                    {{/if}}
								                  </div>
								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
						        </ul>',
				'noteTmpl' : '<ul class="disc-list discussion discussion_{{Discussion.id}}" data-discussion-id="{{ Discussion.id }}">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/follow1.jpg" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon note-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{ Discussion.topic }}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{ AppUser.fname }} {{ AppUser.lname }}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip"><img src="http://localhost/PDD/pyoopil/images/disc-share.png"></a>
						                  <a href="javascript:void(0)" class="vl-t tooltip"><img src="http://localhost/PDD/pyoopil/images/disc-close.png"></a>
						                  <a class="fold-icon tooltip" href="javascript:void(0)"></a>
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt"> {{ Discussion.body }} </p>
						                <div class="arrbox-footer gamification clearfix">
							                {{#if Discussion}}
												<div class="f-left prs-sp">
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
													<div class="clk-tt" style="display: none;">
													  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
													    <li><a href="javascript:void(0)" data-praise-type="eh"><span>EH</span>Engagement</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
													    </li>
													    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
													    </li>
													    <li class="lastli"><a href="javascript:void(0)" data-praise-type="en"><span>EN</span> Endorsement</a>
													    </li>
													  </ul>
													</div>
												</div>
											{{/if}}
											{{#if Discussion.showGamification}}
												<div class="f-right">
													{{displayGamification this}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
						            {{#if Reply}}
							            <div class="bor-rep"><a href="javascript:void(0)" class="view-more">View next 5 answers <img src="http://localhost/PDD/pyoopil/images/view-all.png"></a>
				                        </div>
			                        {{/if}}
			                        {{#unless Reply}}
			                        	<div class="bor-rep"><a href="javascript:void(0)" class="view-more">Be the first to Reply</a>
				                        </div>
				                    {{/unless}}
						          </li>
						          <ul class="replies">
  					            	{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/chat2.png" class="disc-img"></a>
								              </div>
								              <div class="arrow_box">
								                <div class="name-left">
								                  <p class="tname"><a href="javascript:void(0)">{{AppUser.fname}} {{AppUser.lname}}</a></p>
								                  <p class="tby">{{ created }}</p>
								                </div>
								                <div class="icon-right">
								                  <span class="dd-block">
								                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
								                  <div class="arr-dd" style="display: none;">
								                    <ul>
								                      <li><a href="javascript:void(0)">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer gamification clearfix">

								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
					            	<form method="post" class="reply">
						            	<input class="add-ans" name="comment" type="text" placeholder="Add your answer...">
						            	<input type="hidden" name="discussion_id" value="{{Discussion.id}}">
					            	</form>
						        </ul>
					          </ul>',
				'replyTmpl' : '<li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="http://localhost/PDD/pyoopil/images/chat2.png" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <div class="name-left">
						                  <p class="tname"><a href="javascript:void(0)">{{AppUser.fname}} {{AppUser.lname}}</a></p>
						                  <p class="tby">Today at 11:20 am</p>
						                </div>
						                <div class="icon-right">
						                  <span class="dd-block">
						                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
						                  <div class="arr-dd" style="display: none;">
						                    <ul>
						                      <li><a href="javascript:void(0)">Report Abuse</a>
						                      </li>
						                      <li class="lastli"><a href="javascript:void(0)">Delete Comment</a>
						                      </li>
						                    </ul>
						                  </div>
						                  </span>
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt">{{ Reply.comment }}</p>
						                <div class="arrbox-footer gamification clearfix">
						                  
						                </div>
						              </div>
						            </div>
					          	</li>',
				'gamificationDiscussionTmpl' : '{{#if Discussion}}
										<div class="f-left prs-sp">
											<a href="javascript:void(0)" class="icon-title"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
											<div class="clk-tt" style="display: none;">
											  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
											    <li><a href="javascript:void(0)" data-praise-type="eh"><span>EH</span>Engagement</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
											    </li>
											    <li class="lastli"><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Endorsement</a>
											    </li>
											  </ul>
											</div>
										</div>
										{{/if}}
										{{#if Discussion.showGamification}}
											<div class="f-right">
												{{displayGamification this}}
											</div>
						                {{/if}}',
				'gamificationReplyTmpl' : '{{#if Discussion}}
										<div class="f-left prs-sp">
											<a href="javascript:void(0)" class="icon-title"><span class="praise-icon">{{ Reply.display_praise }}</span>Praise</a>
											<div class="clk-tt" style="display: none;">
											  <ul data-type="Reply" data-discussion-id="{{ discussion_id }}" data-reply-id="{{ Reply.id }}" class="praise">
											    <li><a href="javascript:void(0)" data-praise-type="eh"><span>EH</span>Engagement</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
											    </li>
											    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
											    </li>
											    <li class="lastli"><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Endorsement</a>
											    </li>
											  </ul>
											</div>
										</div>
										{{/if}}
										{{#if Discussion.showGamification}}
											<div class="f-right">
												{{displayGamification this}}
											</div>
						                {{/if}}',
				'default' : '<p>No template Available'
			}
		
		getTemplate : (template)->

			if template? and @templates.hasOwnProperty template
				@templates[template]
			else
				@templates.default

	App.classrooms.templates = new Templates()

)($, window, document)