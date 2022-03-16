<!--direct chat Message-->
<div class="tab-pane {{ session('tab') == 'tab_1' ? 'active in' : '' }}" id="tab_1">
    <!-- Direct Chat -->
    <div class="row">
        <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Annotations</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool btn-chat" data-widget="collapse"
                            style="box-shadow: none;"><i class="fa fa-minus"></i>
                        </button>
                        <!--  <button type="button" class="btn btn-box-tool btn-chat" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle" style="box-shadow: none;">
                            <i class="fa fa-comments"></i></button> -->
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                        @foreach ($annotations as $annotation)
                            @if ($annotation->annotation_id == null)
                                <div class="direct-chat-msg  @if ($annotation->user_id ==
                                    Auth::user()->id) right @endif">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name @if ($annotation->user_id ==
                                            Auth::user()->id) pull-right @endif">{{ $annotation->name }} {{ $annotation->prenom }}</span>
                                    <span class="direct-chat-timestamp @if ($annotation->user_id == Auth::user()->id) pull-left @else
                                            pull-right @endif">{{ $annotation->date }}</span>
                                    </div>
                                    <!-- /.direct-chat-info -->
                                    <img class="direct-chat-img" src="{{ asset('/images/user.jpg') }}"
                                        alt="Message User Image"><!-- /.direct-chat-img -->

                                    <div class="direct-chat-text"
                                        style="background: #34c5d6;border-color: #00a65a;color:#212c35;border: 0;border-radius: 5px 5px 5px 5px;">

                                        <div class="row">

                                            <div class="col-md-8">
                                                <div>
                                                    Domaine: {{ $annotation->domaine }} <br>
                                                    Sujet: {{ $annotation->sujet }}
                                                </div>
                                                @if ($annotation->commentaire != null)
                                                    @php
                                                    echo htmlspecialchars_decode(stripslashes($annotation->commentaire))
                                                    ;
                                                    @endphp
                                                @endif
                                            </div>

                                            <div class="col-md-4  pull-right">
                                                @if ($annotation->audio != null)
                                                    <audio class="pull-right" preload="metadata" controls
                                                        controlsList="nodownload" style="height: 25px; width: 350px;">
                                                        <source src="/storage/{{ $annotation->audio }}"
                                                            type="audio/mpeg">
                                                        Sorry, your browser doesn't support html5!
                                                    </audio>
                                                @endif
                                                <a>
                                                    <button id="btn_ann_anno" class="btn btn-default pull-right"
                                                        data-toggle="modal" data-target="#modal_annotation"
                                                        data-id="{{ $annotation->id }}" data-type="annotation"
                                                        style="border-radius: 50%;">
                                                        <i class="fa fa-comment-medical"></i>
                                                    </button>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($annotations as $anno)
                                        @if ($anno->annotation_id == $annotation->id)
                                            <!-- les sous annotations      -->
                                            <div style="padding-left: 55px;">

                                                <div class="direct-chat-msg  @if ($anno->user_id
                                                    == Auth::user()->id) right @endif">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name @if ($anno->user_id == Auth::user()->id) pull-right @endif">{{ $anno->name }}
                                                            {{ $anno->prenom }}</span>
                                                        <span class="direct-chat-timestamp @if ($anno->user_id == Auth::user()->id) pull-left
                                                        @else pull-right @endif">{{ $anno->date }}</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="{{ asset('/images/user.jpg') }}"
                                                        alt="Message User Image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text"
                                                        style="background: #34cccc;border-color: #00a65a;color:#212c35;border: 0;border-radius: 5px 5px 5px 5px;">
                                                        <div class="row">

                                                            <div class="col-md-8">
                                                                <div>
                                                                    Domaine: {{ $anno->domaine }} <br>
                                                                    Sujet: {{ $anno->sujet }}
                                                                </div>
                                                                @if ($anno->commentaire != null)
                                                                    @php
                                                                    echo
                                                                    htmlspecialchars_decode(stripslashes($anno->commentaire))
                                                                    ;
                                                                    @endphp
                                                                @endif
                                                            </div>

                                                            <div class="col-md-4  pull-right">
                                                                @if ($anno->audio != null)
                                                                    <audio class="pull-right" preload="metadata"
                                                                        controls controlsList="nodownload"
                                                                        style="height: 25px; width: 350px;">
                                                                        <source src="/storage/{{ $anno->audio }}"
                                                                            type="audio/mpeg">
                                                                        Sorry, your browser doesn't support html5!
                                                                    </audio>
                                                                @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>

                                            </div>
                                            <!-- fin les sous annotations-->
                                        @endif
                                    @endforeach
                                    <!-- /.direct-chat-text -->
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!--/.direct-chat-messages-->

                </div>
                <!-- /.box-body -->
                <!-- <div class="box-footer">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Taper un message ..." class="form-control" required>
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat envoyer" data-id="{{ $patient->id }}" data-user="{{ Auth::user()->id }}" data-name="{{ Auth::user()->name }} {{ Auth::user()->prenom }}" >Envoyer</button> </span>
                    </div>
                </div> -->
                <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
        <!-- /.col -->
    </div>
</div>
