<template>
          <div class="tab-pane fade show active" id="chat1" role="tabpanel">
            <div class="item">
              <div class="content">
                <div class="container">
                  <div class="top">
                    <div class="headline">
                      <img src="/avatar/avatar-male-2.jpg" alt="avatar">
                      <div class="content">
                        <h5>{{ message }}</h5>
                        <span>Away</span>
                      </div>
                    </div>
                    <ul>
                      <li><button type="button" class="btn"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect><path d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z"></path></g></g></svg></i></button></li>
                      <li><button type="button" class="btn"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-phone eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"></rect><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"></path></g></g></svg></i></button></li>
                      <li><button type="button" class="btn" data-toggle="modal" data-target="#compose"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-add eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"></rect><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg></i></button></li>
                      <li><button type="button" class="btn" data-utility="open"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-info eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg></i></button></li>
                      <li><button type="button" class="btn round" data-chat="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-back"><g data-name="Layer 2"><g data-name="arrow-ios-back"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect><path d="M13.83 19a1 1 0 0 1-.78-.37l-4.83-6a1 1 0 0 1 0-1.27l5-6a1 1 0 0 1 1.54 1.28L10.29 12l4.32 5.36a1 1 0 0 1-.78 1.64z"></path></g></g></svg></button></li>
                      <li><button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></i></button>
                        <div class="dropdown-menu">
                          <button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect><path d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z"></path></g></g></svg>Video call</button>
                          <button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-phone"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"></rect><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"></path></g></g></svg>Voice call</button>
                          <button type="button" class="dropdown-item" data-toggle="modal" data-target="#compose"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-add"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"></rect><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg>Add people</button>
                          <button type="button" class="dropdown-item" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-info"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg>Information</button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="middle" id="scroll">
                  <div class="container">
                    <ul v-chat-scroll>
                      <message
                      v-for="(value,index) in chat"
                      :key=index
                      :user = value.user
                      :time = value.time
                      >
                        @{{ value.message }}
                      </message>
                    </ul>
                  </div>
                </div>
                <div class="container">
                  <div class="bottom">
                    <form>
                      <input type="hidden"  id="to_user" value="">
                      <textarea class="form-control" placeholder="Type message..." rows="1" v-model='message' @keyup.enter='$emit(send)></textarea>
                      <button class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-paper-plane"><g data-name="Layer 2"><g data-name="paper-plane"><rect width="24" height="24" opacity="0"></rect><path d="M21 4a1.31 1.31 0 0 0-.06-.27v-.09a1 1 0 0 0-.2-.3 1 1 0 0 0-.29-.19h-.09a.86.86 0 0 0-.31-.15H20a1 1 0 0 0-.3 0l-18 6a1 1 0 0 0 0 1.9l8.53 2.84 2.84 8.53a1 1 0 0 0 1.9 0l6-18A1 1 0 0 0 21 4zm-4.7 2.29l-5.57 5.57L5.16 10zM14 18.84l-1.86-5.57 5.57-5.57z"></path></g></g></svg></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Start of Utility -->
              <div class="utility">
                <div class="container">
                  <button type="button" class="close" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-close"><g data-name="Layer 2"><g data-name="close"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path></g></g></svg></button>
                  <ul class="nav" role="tablist">
                  </ul>
                  <div class="tab-content">
                    <!-- Start of Users -->
                    <div class="tab-pane fade active show" id="users" role="tabpanel">
                      <h4>Utilisateurs</h4>
                      <hr>
                      <ul class="users">
                      </ul>
                    </div>
                    <!-- End of Users -->
                    <!-- Start of Files -->
                    <div class="tab-pane fade" id="files" role="tabpanel">
                      <h4>Files</h4>
                      <div class="upload">
                        <label>
                          <input type="file">
                          <span>Drag &amp; drop files here</span>
                        </label>
                      </div>
                      <ul class="files">
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-1.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>workbox.js</h5></a>
                            <span>2kb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-2.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>bug_report</h5></a>
                            <span>1kb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-briefcase"><g data-name="Layer 2"><g data-name="briefcase"><rect width="24" height="24" opacity="0"></rect><path d="M7 21h10V7h-1V5.5A2.5 2.5 0 0 0 13.5 3h-3A2.5 2.5 0 0 0 8 5.5V7H7zm3-15.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V7h-4z"></path><path d="M19 7v14a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3z"></path><path d="M5 7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-2.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>nuget.zip</h5></a>
                            <span>7mb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-image-2"><g data-name="Layer 2"><g data-name="image-2"><rect width="24" height="24" opacity="0"></rect><path d="M18 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zM8 7a1.5 1.5 0 1 1-1.5 1.5A1.5 1.5 0 0 1 8 7zm11 10.83A1.09 1.09 0 0 1 18 19H6l7.57-6.82a.69.69 0 0 1 .93 0l4.5 4.48z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-4.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>clearfix.jpg</h5></a>
                            <span>1kb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-5.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>package</h5></a>
                            <span>4mb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                        <li>
                          <ul class="avatars">
                            <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                            <li><a href="http://grayshift.io/themes/swipe/#"><img src="/avatar/avatar-male-6.jpg" alt="avatar"></a></li>
                          </ul>
                          <div class="meta">
                            <a href="http://grayshift.io/themes/swipe/#"><h5>plugins.js</h5></a>
                            <span>3kb</span>
                          </div>
                          <div class="dropdown">
                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button type="button" class="dropdown-item">Edit</button>
                              <button type="button" class="dropdown-item">Share</button>
                              <button type="button" class="dropdown-item">Delete</button>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <!-- End of Files -->
                  </div>
                </div>
              </div>
              <!-- End of Utility -->
            </div>
          </div>
</template>

<script>
    export default {
        props:[
            'nom',
            'prenom',
            'time'
        ],
        computed:{

        },
        mounted() {
            console.log('Chat Component mounted.')
        }
    }
</script>

