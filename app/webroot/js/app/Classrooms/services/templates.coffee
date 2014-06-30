App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->


	class Templates

		constructor : ->

			@setTemplates()

		setTemplates : ->

			@templates = {
				'classroomTile' : '<li><a href="{{ Classroom.Url }}">{{#if UsersClassroom.is_restricted}}<div class="lock-state"><p>! You do not have access to this class. Please contact the owner</p></div>{{/if}}{{#if UsersClassroom.is_teaching }}<div class="class-head">My Class</div>{{/if}}{{#if Classroom.is_private}}<img src="{{image "lock_icon.png"}}" class="lock">{{/if}}<div class="doc-top"><p class="subject">{{ Classroom.title }}</p><div>by</div><div><span class="online"></span>{{ Classroom.Educator }}</div><div class="totalstudent">( {{Classroom.users_classroom_count}} Students)</div></div>{{#if Classroom.Campus.name}}<p class="doc-end"> {{Classroom.Campus.name}} </p>{{/if}}</a></li>',
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
					                  <a href="{{link "Classrooms"}}" class="sub-btn">Take me to my classrooms</a>
					                </div>
					              </div>
					            </div>
					          </div>',
				"discussionTmpl" : '<ul class="disc-list discussion discussion_{{Discussion.id}}" data-discussion-id="{{ Discussion.id }}">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="{{image "follow1.jpg"}}" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon quest-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{ Discussion.topic }}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{ AppUser.fname }} {{ AppUser.lname }}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip sharePost" title="Share to My Room"><img src="{{image "disc-share.png"}}"></a>
						                  <a href="javascript:void(0)" class="vl-t tooltip deletePost" title="Delete"><img src="{{image "disc-close.png"}}"></a>
						                  {{#if Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost folded-icon" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/if}}
						                  {{#unless Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/unless}}
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt"> {{ Discussion.body }} </p>
						                <div class="arrbox-footer gamification clearfix">
											<div class="f-left prs-sp">
												{{#if Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Discussion.display_praise }}</span>Praise</a>
												{{/if}}
												{{#unless Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
												{{/unless}}
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											{{#if Discussion.showGamification}}
												<div class="f-right">
													{{#displayGamification Gamificationvote}}
													{{/displayGamification}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
						            <div class="bor-rep"><a href="javascript:void(0)" class="view-more" data-current-page="1">View next 5 answers <img src="{{image "view-all.png"}}"></a>
			                        </div>
						          </li>
						          <ul class="replies">
  					            	{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="{{image "chat2.png"}}" class="disc-img"></a>
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
								                      <li><a href="javascript:void(0)" class="reportAbuse">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)" class="deleteComment">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer gamification clearfix">
													<div class="f-left prs-sp">
														{{#if showGamification}}
															<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ display_praise }}</span>Praise</a>
														{{/if}}
														{{#unless showGamification}}
															<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ display_praise }}</span>Praise</a>
														{{/unless}}
														<div class="clk-tt" style="display: none;">
														  <ul data-type="Reply" data-reply-id="{{ id }}" class="praise">
														    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
														    </li>
														    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
														    </li>
														  </ul>
														</div>
													</div>
													{{#if showGamification}}
														<div class="f-right">
															{{#displayGamification Gamificationvote}}
															{{/displayGamification}}
														</div>
									                {{/if}}
								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
						        </ul>
						        <form method="post" class="reply">
					            	<input class="add-ans" name="comment" type="text" placeholder="Add your answer...">
					            	<input type="hidden" name="discussion_id" value="{{Discussion.id}}">
				            	</form>
					          </ul>',
				'pollTmpl' : '<ul class="disc-list discussion discussion_{{Discussion.id}}" data-discussion-id="{{ Discussion.id }}">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="{{image "follow4.jpg"}}" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{Discussion.topic}}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{AppUser.fname}} {{AppUser.lname}}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip sharePost" title="Share to My Room"><img src="{{image "disc-share.png"}}"></a>
						                  <a href="javascript:void(0)" class="vl-t tooltip deletePost" title="Delete"><img src="{{image "disc-close.png"}}"></a>
						                  {{#if Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost folded-icon" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/if}}
						                  {{#unless Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/unless}}
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt">{{ Discussion.body }}</p>
						                <div class="clearfix polling">
						                    <div class="poll-left">
						                    	{{#Poll Pollchoice}}
					                        	{{/Poll}}
					                        </div>
						               		<div class="poll-right">
						               			{{#unless Pollchoice.showPollVote}}
							                   		<div class="chart" data-chart="{{Chart Pollchoice }}"></div>
							                   	{{/unless}}
						                   	</div>
						                </div>
						                
						                <div class="arrbox-footer gamification clearfix">
											<div class="f-left prs-sp">
												{{#if Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Discussion.display_praise }}</span>Praise</a>
												{{/if}}
												{{#unless Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
												{{/unless}}
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											{{#if Discussion.showGamification}}
												<div class="f-right">
													{{#displayGamification Gamificationvote}}
													{{/displayGamification}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
						            <div class="bor-rep"><a href="javascript:void(0)" class="view-more" data-current-page="1">View all 5 answers <img src="{{image "view-all.png"}}"></a>
						            </div>
						          </li>
						          <ul class="replies">
						      		{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="{{image "chat2.png"}}" class="disc-img"></a>
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
								                      <li><a href="javascript:void(0)" class="reportAbuse">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)" class="deleteComment">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer gamification clearfix">
													<div class="f-left prs-sp">
														{{#if showGamification}}
															<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ display_praise }}</span>Praise</a>
														{{/if}}
														{{#unless showGamification}}
															<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ display_praise }}</span>Praise</a>
														{{/unless}}
														<div class="clk-tt" style="display: none;">
														  <ul data-type="Reply" data-reply-id="{{ id }}" class="praise">
														    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
														    </li>
														    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
														    </li>
														  </ul>
														</div>
													</div>
													{{#if showGamification}}
														<div class="f-right">
															{{#displayGamification Gamificationvote}}
															{{/displayGamification}}
														</div>
									                {{/if}}
								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
					            	</ul>
					            	<form method="post" class="reply">
						            	<input class="add-ans" name="comment" type="text" placeholder="Add your answer...">
						            	<input type="hidden" name="discussion_id" value="{{Discussion.id}}">
					            	</form>
						        </ul>',
				'noteTmpl' : '<ul class="disc-list discussion discussion_{{Discussion.id}}" data-discussion-id="{{ Discussion.id }}">
						          <li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="{{image "follow1.jpg"}}" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <span class="arrowbox-icon note-icon"></span>
						                <div class="name-left">
						                  <p class="tname">{{ Discussion.topic }}</p>
						                  <p class="tby"><a href="javascript:void(0)">by {{ AppUser.fname }} {{ AppUser.lname }}</a></p>
						                  <p class="tby">{{ Discussion.created }}</p>
						                </div>
						                <div class="icon-right">
						                  <a href="javascript:void(0)" class="vl-t tooltip sharePost" title="Share to My Room"><img src="{{image "disc-share.png"}}"></a>
						                  <a href="javascript:void(0)" class="vl-t tooltip deletePost" title="Delete"><img src="{{image "disc-close.png"}}"></a>
						                  {{#if Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost folded-icon" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/if}}
						                  {{#unless Discussion.isFolded}}
						                  <a class="fold-icon tooltip foldPost" href="javascript:void(0)" title="Fold/Unfold"></a>
						                  {{/unless}}
						                </div>
						                <div class="clear"></div>
						                {{#safehtml Discussion.body }}
						                	
						                {{/safehtml}}
						                <div class="arrbox-footer gamification clearfix">
											<div class="f-left prs-sp">
												{{#if Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Discussion.display_praise }}</span>Praise</a>
												{{/if}}
												{{#unless Discussion.showGamification}}
													<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ Discussion.display_praise }}</span>Praise</a>
												{{/unless}}
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											{{#if Discussion.showGamification}}
												<div class="f-right">
													{{#displayGamification Gamificationvote}}
													{{/displayGamification}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
						            <div class="bor-rep"><a href="javascript:void(0)" class="view-more" data-current-page="1">View next 5 answers <img src="{{image "view-all.png"}}"></a>
			                        </div>
						          </li>
						          <ul class="replies">
  					            	{{#each Reply}}
					            		<li>
								            <div class="disc-box clearfix">
								              <div class="disc-left">
								                <a href="javascript:void(0)"><img src="{{image "chat2.png"}}" class="disc-img"></a>
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
								                      <li><a href="javascript:void(0)" class="reportAbuse">Report Abuse</a>
								                      </li>
								                      <li class="lastli"><a href="javascript:void(0)" class="deleteComment">Delete Comment</a>
								                      </li>
								                    </ul>
								                  </div>
								                  </span>
								                </div>
								                <div class="clear"></div>
								                <p class="ttxt">{{ comment }}</p>
								                <div class="arrbox-footer gamification clearfix">
													<div class="f-left prs-sp">
														{{#if showGamification}}
															<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ display_praise }}</span>Praise</a>
														{{/if}}
														{{#unless showGamification}}
															<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ display_praise }}</span>Praise</a>
														{{/unless}}
														<div class="clk-tt" style="display: none;">
														  <ul data-type="Reply" data-reply-id="{{ id }}" class="praise">
														    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
														    </li>
														    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
														    </li>
														    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
														    </li>
														  </ul>
														</div>
													</div>
													{{#if showGamification}}
														<div class="f-right">
															{{#displayGamification Gamificationvote}}
															{{/displayGamification}}
														</div>
									                {{/if}}
								                </div>
								              </div>
								            </div>
								          </li>
					            	{{/each}}
						        </ul>
						        <form method="post" class="reply">
					            	<input class="add-ans" name="comment" type="text" placeholder="Add your answer...">
					            	<input type="hidden" name="discussion_id" value="{{Discussion.id}}">
				            	</form>
					          </ul>',
				'replyTmpl' : '<li>
						            <div class="disc-box clearfix">
						              <div class="disc-left">
						                <a href="javascript:void(0)"><img src="{{image "chat2.png"}}" class="disc-img"></a>
						              </div>
						              <div class="arrow_box">
						                <div class="name-left">
						                  <p class="tname"><a href="javascript:void(0)">{{AppUser.fname}} {{AppUser.lname}}</a></p>
						                  <p class="tby">Today at {{Reply.created}}</p>
						                </div>
						                <div class="icon-right">
						                  <span class="dd-block">
						                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
						                  <div class="arr-dd" style="display: none;">
						                    <ul>
						                      <li><a href="javascript:void(0)" class="reportAbuse">Report Abuse</a>
						                      </li>
						                      <li class="lastli"><a href="javascript:void(0)" class="deleteComment">Delete Comment</a>
						                      </li>
						                    </ul>
						                  </div>
						                  </span>
						                </div>
						                <div class="clear"></div>
						                <p class="ttxt">{{ Reply.comment }}</p>
						                <div class="arrbox-footer gamification clearfix">
											<div class="f-left prs-sp">
												{{#if Reply.showGamification}}
													<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Reply.display_praise }}</span>Praise</a>
												{{/if}}
												{{#unless Reply.showGamification}}
													<a href="javascript:void(0)" class="icon-title addPraise"><span class="praise-icon">{{ Reply.display_praise }}</span>Praise</a>
												{{/unless}}
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Reply" data-reply-id="{{ Reply.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											{{#if Reply.showGamification}}
												<div class="f-right">
													{{#displayGamification Gamificationvote}}
													{{/displayGamification}}
												</div>
							                {{/if}}
						                </div>
						              </div>
						            </div>
					          	</li>',
				'gamificationDiscussionTmpl' : '<div class="f-left prs-sp">
												<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Discussion.display_praise }}</span>Praise</a>
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Discussion" data-discussion-id="{{ Discussion.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											<div class="f-right">
												{{#displayGamification Gamificationvote}}
												{{/displayGamification}}
											</div>',
				'gamificationReplyTmpl' : '<div class="f-left prs-sp">
												<a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise">{{ Reply.display_praise }}</span>Praise</a>
												<div class="clk-tt" style="display: none;">
												  <ul data-type="Reply" data-reply-id="{{ Reply.id }}" class="praise">
												    <li><a href="javascript:void(0)" data-praise-type="en"><span>EN</span>Engagement</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="in"><span>IN</span>Intelligence</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="cu"><span>CU</span>Curiosity</a>
												    </li>
												    <li><a href="javascript:void(0)" data-praise-type="co"><span>CO</span>Contribution</a>
												    </li>
												    <li class="lastli"><a href="javascript:void(0)" data-praise-type="ed"><span>ED</span> Endorsement</a>
												    </li>
												  </ul>
												</div>
											</div>
											<div class="f-right">
												{{#displayGamification Gamificationvote}}
												{{/displayGamification}}
											</div>',
				'announcementTmpl' : '<div class="listbox">
							              <div class="imgbox">
							                <a href="javascript:void(0)">
							                  <img src="{{image "follow1.jpg"}}">
							                </a>
							              </div>
							              <div class="userinfo">
							                <h4>{{ Announcement.subject }}
							                <span>
							                  <a href="profile-view.htm">by {{AppUser.fname}} {{AppUser.lname}}</a>
							                </span></h4>
							                <div class="datetime clearfix">
							                	{{#if Announcement.file_path}}
							                		<span class="attach-icon"></span>
							                	{{/if}}
							                	{{ Announcement.created }}
							                </div>
							              </div>
							              <p>{{ Announcement.body }}</p>
							              {{#if Announcement.file_path}}
							              <p class="cl">
								              <a class="dlfile" href="{{Announcement.file_path}}" target="_blank">{{Announcement.filename}}</a> 
								              <a class="down-icon" href="javascript:void(0)"></a>
							              </p>
							              {{/if}}
						              </div>',
				'libraryTmpl' : '
							    <div class="attach-doc classlibrary stud-pnl">
						          <div class="doc-heading clearfix">
						            <input type="text" class="doc-input" value="{{ Topic.name }}" maxlength="70" readonly="readonly">
						            <div class="lib-right">
						              <a href="javascript:void(0)" class="lib-edit tooltip" title="Edit Topic"></a>
						              <a href="javascript:void(0)" class="lib-delete tooltip" title="Delete"></a>
						              <a href="javascript:void(0)" class="lib-download tooltip" title="Download"></a>
						              <div class="click-lib click-icon tooltip" title="Click to Slide"></div>
						            </div>
						          </div>
						          <div class="contentblock" style="display: none;">
						            <p class="classlibraryhd">Documents </p>
						            <ul class="doc-list">
						            	{{#each Documents}}
						              <li>
						                <a href="javascript:void(0)" class="del-lib"></a>
						                 <a href="http://docs.google.com/viewer?url={{ file_path }}&embedded=true?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]">
						                 <div class="doc-top">
						                 
						                  <p>{{filename}}</p>
						                  <p>Subject</p>
						                 
						                </div> </a>
						                <div class="doc-end clearfix">
					                	<a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="{{icon this}}" class="m3-0"></a>
						                  <p class="f-right">Posted<br>
						                    {{created}}</p>
						                </div>
						              </li>
						              {{/each}}
						            </ul>
						            <p class="classlibraryhd">Links</p>
						            <ul class="doc-list link-lst">
						            	{{#each Link}}
							              <li>
							                <a href="javascript:void(0)" class="del-lib"></a>
							                <a href="{{linktext}}" target="_blank">
								                <div class="doc-top">
								                  <p>Go To Link</p>
								                </div>
								                <div class="doc-end clearfix">
								                  <img src="{{image "link-icon.png"}}" class="m3-0">
								                  <p class="f-right">Posted<br>
								                    {{ created }}</p>
								                </div>
							                </a>
							              </li>
							            {{/each}}
						            </ul>
						            <p class="classlibraryhd">Video</p>
						            <ul class="doc-list imglist">
						            	{{#each Video}}
							              <li>
							                <div class="img-wrapper">
							                  <a href="javascript:void(0)" class="del-lib"></a>
							                  <a href="{{linktext}}" rel="prettyPhoto[pp_gal]">
							                  <img src="{{image "classroom/library-video1.jpg"}}">
							                  <div class="piccaption clearfix">Posted <br>
							                    {{ created }}</div>
							                  </a>
							                </div>
							              </li>
							            {{/each}}
						            </ul>
						            <p class="classlibraryhd">Pictures</p>
						            <ul class="doc-list imglist">
						            	{{#each Pictures}}
							              <li>
							                <div class="img-wrapper">
							                  <a href="javascript:void(0)" class="del-lib"></a>
							                  <a href="{{file_path}}" rel="prettyPhoto[pp_gal]">
							                  <img src="{{thumbnail_path}}">
							                  <div class="piccaption clearfix">Posted <br>
							                    {{ created }}</div>
							                  </a>
							                </div>
							              </li>
							            {{/each}}
						            </ul>
						            <p class="classlibraryhd">Presentation</p>
						            <ul class="doc-list">
						              <li>
						                <a href="javascript:void(0)" class="del-lib"></a>
						                <div class="doc-top">
						                  <p>{{filename}}</p>
						                  <p>Subject</p>
						                </div>
						                <div class="doc-end clearfix">
						                  <img src="{{image "ppt_icon.png"}}" class="m3-0">
						                  <p class="f-right">Posted<br>
						                    {{ created }}</p>
						                </div>
						              </li>
						            </ul>
						          </div>
						        </div>
							    ',
				'pollingTmpl' : '<div class="poll-left">
			                    	{{#Poll Pollchoice}}
		                        	{{/Poll}}
		                        </div>
			               		<div class="poll-right">
			               			{{#Chart PollChoice}}
			               			{{/Chart}}
			                   	</div>',
				'default' : '<p>No template Available'
			}
		
		getTemplate : (template)->

			if template? and @templates.hasOwnProperty template
				@templates[template]
			else
				@templates.default

	App.classrooms.templates = new Templates()

)($, window, document)
