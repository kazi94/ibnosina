<!DOCTYPE html>
<!-- saved from url=(0033)http://grayshift.io/themes/swipe/ -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Room Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="#">
    <!-- Bootstrap core CSS -->
    <link href="/plugins/swipe/css/swipe/bootstrap.min.css" type="text/css" rel="stylesheet">
    <!-- Swipe core CSS -->
    <link href="/plugins/swipe/css/swipe/swipe.min.css" type="text/css" rel="stylesheet">
    <link href="/plugins/swipe/css/swipe/dark.min.css" type="text/css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/scrollbar.css')); ?>">
    <link href="http://grayshift.io/themes/swipe/dist/img/favicon.png" type="image/png" rel="icon">
    <style type="text/css">
        /**
   * @license
   * Copyright Akveo. All Rights Reserved.
   * Licensed under the MIT License. See License.txt in the project root for license information.
   */
        .eva-animation {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .eva-infinite {
            animation-iteration-count: infinite;
        }

        .eva-icon-shake {
            animation-name: eva-shake;
        }

        .eva-icon-zoom {
            animation-name: eva-zoomIn;
        }

        .eva-icon-pulse {
            animation-name: eva-pulse;
        }

        .eva-icon-flip {
            animation-name: eva-flipInY;
        }

        .eva-hover {
            display: inline-block;
        }

        .eva-hover:hover .eva-icon-hover-shake,
        .eva-parent-hover:hover .eva-icon-hover-shake {
            animation-name: eva-shake;
        }

        .eva-hover:hover .eva-icon-hover-zoom,
        .eva-parent-hover:hover .eva-icon-hover-zoom {
            animation-name: eva-zoomIn;
        }

        .eva-hover:hover .eva-icon-hover-pulse,
        .eva-parent-hover:hover .eva-icon-hover-pulse {
            animation-name: eva-pulse;
        }

        .eva-hover:hover .eva-icon-hover-flip,
        .eva-parent-hover:hover .eva-icon-hover-flip {
            animation-name: eva-flipInY;
        }

        @keyframes  eva-flipInY {
            from {
                transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
                animation-timing-function: ease-in;
                opacity: 0;
            }

            40% {
                transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
                animation-timing-function: ease-in;
            }

            60% {
                transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
                opacity: 1;
            }

            80% {
                transform: perspective(400px) rotate3d(0, 1, 0, -5deg);
            }

            to {
                transform: perspective(400px);
            }
        }

        @keyframes  eva-shake {

            from,
            to {
                transform: translate3d(0, 0, 0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translate3d(-3px, 0, 0);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translate3d(3px, 0, 0);
            }
        }

        @keyframes  eva-pulse {
            from {
                transform: scale3d(1, 1, 1);
            }

            50% {
                transform: scale3d(1.2, 1.2, 1.2);
            }

            to {
                transform: scale3d(1, 1, 1);
            }
        }

        @keyframes  eva-zoomIn {
            from {
                opacity: 1;
                transform: scale3d(0.5, 0.5, 0.5);
            }

            50% {
                opacity: 1;
            }
        }

        .list-group {
            overflow-y: scroll;
            height: 365px;
        }

    </style>

</head>

<body style="">
    <!-- Layout -->
    <div class="layout" id="app1">
        <!-- Start of Sidebar -->
        <div class="sidebar">
            <div class="container">
                <div class="tab-content">
                    <!-- Start of Discussions -->
                    <div class="tab-pane fade show active" id="conversations" role="tabpanel">
                        
                        
                        
                        
                        
                        <div class="middle">
                            <h4>Discussions</h4>
                            
                            <hr>

                            <ul class="nav discussions" role="tablist">

                                <contact v-on:show_conversation="showConversation" v-for="value,index in contact"
                                    :auth_id="'<?php echo e(Auth::id()); ?>'" :id="value.id" :prenom="value.prenom"
                                    :nom="value.nom" :message="value.last_message" :time="value.date_message"
                                    :status="value.status" :url="value.url">
                                </contact>

                            </ul>
                        </div>
                    </div>
                    <!-- End of Discussions -->
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->
        <!-- Start of Chat -->
        <div class="chat open">
            <div class="tab-content">
                <!-- Start of Chat Room -->
                <div class="tab-pane fade show " id="chat1" role="tabpanel">
                    <div class="item">
                        <div class="content">
                            <div class="container">
                                <div class="top">
                                    <div class="headline">
                                        <img src="https://ui-avatars.com/api/?name=j+d" alt="avatar">
                                        <div class="content">
                                            <h5>{{ to_user_name }} {{ to_user_prenom }}</h5>
                                            <span>{{ status }}</span>
                                        </div>
                                    </div>
                                    <ul>
                                        <li><button type="button" class="btn"><i class="eva-hover"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24"
                                                        class="eva eva-video eva-animation eva-icon-hover-pulse">
                                                        <g data-name="Layer 2">
                                                            <g data-name="video">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg></i></button></li>
                                        <li><button type="button" class="btn"><i class="eva-hover"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24"
                                                        class="eva eva-phone eva-animation eva-icon-hover-pulse">
                                                        <g data-name="Layer 2">
                                                            <g data-name="phone">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg></i></button></li>
                                        <li><button type="button" class="btn" data-toggle="modal"
                                                data-target="#compose"><i class="eva-hover"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24"
                                                        class="eva eva-person-add eva-animation eva-icon-hover-pulse">
                                                        <g data-name="Layer 2">
                                                            <g data-name="person-add">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z">
                                                                </path>
                                                                <path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z">
                                                                </path>
                                                                <path
                                                                    d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg></i></button></li>
                                        <li><button type="button" class="btn" data-utility="open"><i
                                                    class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24"
                                                        class="eva eva-info eva-animation eva-icon-hover-pulse">
                                                        <g data-name="Layer 2">
                                                            <g data-name="info">
                                                                <rect width="24" height="24"
                                                                    transform="rotate(180 12 12)" opacity="0">
                                                                </rect>
                                                                <path
                                                                    d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg></i></button></li>
                                        <li><button type="button" class="btn round" data-chat="open"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" class="eva eva-arrow-ios-back">
                                                    <g data-name="Layer 2">
                                                        <g data-name="arrow-ios-back">
                                                            <rect width="24" height="24" transform="rotate(90 12 12)"
                                                                opacity="0"></rect>
                                                            <path
                                                                d="M13.83 19a1 1 0 0 1-.78-.37l-4.83-6a1 1 0 0 1 0-1.27l5-6a1 1 0 0 1 1.54 1.28L10.29 12l4.32 5.36a1 1 0 0 1-.78 1.64z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg></button></li>
                                        <li><button type="button" class="btn" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><i class="eva-hover"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24"
                                                        class="eva eva-more-vertical eva-animation eva-icon-hover-pulse">
                                                        <g data-name="Layer 2">
                                                            <g data-name="more-vertical">
                                                                <rect width="24" height="24"
                                                                    transform="rotate(-90 12 12)" opacity="0">
                                                                </rect>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <circle cx="12" cy="5" r="2"></circle>
                                                                <circle cx="12" cy="19" r="2"></circle>
                                                            </g>
                                                        </g>
                                                    </svg></i></button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" class="eva eva-video">
                                                        <g data-name="Layer 2">
                                                            <g data-name="video">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>Video call</button>
                                                <button type="button" class="dropdown-item"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" class="eva eva-phone">
                                                        <g data-name="Layer 2">
                                                            <g data-name="phone">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>Voice call</button>
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#compose"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        class="eva eva-person-add">
                                                        <g data-name="Layer 2">
                                                            <g data-name="person-add">
                                                                <rect width="24" height="24" opacity="0"></rect>
                                                                <path
                                                                    d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z">
                                                                </path>
                                                                <path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z">
                                                                </path>
                                                                <path
                                                                    d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>Add people</button>
                                                <button type="button" class="dropdown-item" data-utility="open"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" class="eva eva-info">
                                                        <g data-name="Layer 2">
                                                            <g data-name="info">
                                                                <rect width="24" height="24"
                                                                    transform="rotate(180 12 12)" opacity="0">
                                                                </rect>
                                                                <path
                                                                    d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </svg>Information</button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="middle">
                                <div class="container" id="scroll">
                                    <ul v-if="chat.length >=  1" class="list-group" v-chat-scroll>
                                        <message v-for="value,index in chat" :key=value.index :user=value.user
                                            :time=value.time :styles=value.style>
                                            {{ value . message }}
                                        </message>
                                    </ul>
                                </div>
                            </div>
                            <div class="container">
                                <div class="bottom">
                                    <form>

                                        <textarea class="form-control" placeholder="Type message..." rows="1"
                                            v-model='message' @keyup.enter='send'></textarea>
                                        <button class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" class="eva eva-paper-plane">
                                                <g data-name="Layer 2">
                                                    <g data-name="paper-plane">
                                                        <rect width="24" height="24" opacity="0"></rect>
                                                        <path
                                                            d="M21 4a1.31 1.31 0 0 0-.06-.27v-.09a1 1 0 0 0-.2-.3 1 1 0 0 0-.29-.19h-.09a.86.86 0 0 0-.31-.15H20a1 1 0 0 0-.3 0l-18 6a1 1 0 0 0 0 1.9l8.53 2.84 2.84 8.53a1 1 0 0 0 1.9 0l6-18A1 1 0 0 0 21 4zm-4.7 2.29l-5.57 5.57L5.16 10zM14 18.84l-1.86-5.57 5.57-5.57z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Start of Utility -->
                        <div class="utility">
                            <div class="container">
                                <button type="button" class="close" data-utility="open"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        class="eva eva-close">
                                        <g data-name="Layer 2">
                                            <g data-name="close">
                                                <rect width="24" height="24" transform="rotate(180 12 12)" opacity="0">
                                                </rect>
                                                <path
                                                    d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg></button>
                                
                                <ul class="nav" role="tablist">
                                    
                                    
                                </ul>
                                <div class="tab-content">
                                    <!-- Start of Users -->
                                    <div class="tab-pane fade active show" id="users" role="tabpanel">
                                        <h4>Utilisateurs</h4>
                                        <hr>
                                        <ul class="users">
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <right-contact v-on:show_conversation="showConversation"
                                                    auth_id="'<?php echo e(Auth::id()); ?>'" :id="'<?php echo e($user->id); ?>'"
                                                    :prenom="'<?php echo e($user->prenom); ?>'" :nom="'<?php echo e($user->name); ?>'"
                                                    :service="'<?php echo e($user->service); ?>'"
                                                    :grade="'<?php echo e($user->grade); ?>'"
                                                    url="https://ui-avatars.com/api/?name=<?php echo e($user->prenom); ?>+<?php echo e($user->name); ?>">
                                                </right-contact>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <!-- End of Users -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Utility -->
                    </div>
                </div>
                <!-- End of Chat Room -->
            </div>
        </div>
        <!-- End of Chat -->
    </div>
    <!-- Layout -->
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/jquery-slim.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/eva.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/swipe/js/swipe/swipe.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/appChat.js')); ?>"></script>
</body>

</html>


<?php /**PATH C:\laragon\www\anapharm\resources\views\others\chat_room.blade.php ENDPATH**/ ?>