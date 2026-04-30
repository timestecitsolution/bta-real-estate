
<div class="app-header white box-shadow navbar-md">
    <div class="navbar">
        <!-- Open side - Naviation on mobile -->
        <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up">
            <i class="material-icons  md-30 opacity-8">&#xe5d2;</i>
        </a>

        <!-- Page title - Bind to $state's title -->
        <div class="navbar-item pull-left h5" ng-bind="$state.current.data.title" id="pageTitle"></div>

        <!-- navbar right -->
        <ul class="nav navbar-nav pull-right">
            <li class="nav-item pa-13">
                <a class="btn btn info" href="{{ route("frontendRoute") }}" target="_blank">
                    <i class="material-icons">&#xe895;</i> <small>{{ __('backend.sitePreview') }}</small>
                </a>
            </li>
            <?php
            $webmailsAlerts = Helper::webmailsAlerts();
            $eventsAlerts = Helper::eventsAlerts();
            $alerts = count($webmailsAlerts) + count($eventsAlerts);
            ?>
            @if($alerts >0)
                <!-- <li class="nav-item dropdown pos-stc-xs">
                    <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons">&#xe7f5;</i>
                        @if($alerts >0)
                            <span class="label label-sm up warn">{{ $alerts }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu pull-right w-xl animated fadeInUp no-bg no-border no-shadow">
                        <div class="box dark">
                            <div class="box p-a scrollable maxHeight320">
                                <ul class="list-group list-group-gap m-a-0">
                                    @foreach($webmailsAlerts as $webmailsAlert)
                                        <li class="list-group-item lt box-shadow-z0 b">
                                    <span class="clear block">
                                        <small>{{ $webmailsAlert->from_name }}</small><br>
                                        <a href="{{ route("webmailsEdit",["id"=>$webmailsAlert->id]) }}"
                                           class="text-primary">{{ $webmailsAlert->title }}</a>
                                        <br>
                                        <small class="text-muted">
                                            {{ date('d M Y  h:i A', strtotime($webmailsAlert->date)) }}
                                        </small>
                                    </span></li>
                                    @endforeach
                                    @foreach($eventsAlerts as $eventsAlert)
                                        <li class="list-group-item lt box-shadow-z0 b">
                                    <span class="clear block">
                                        <a href="{{ route("calendarEdit",["id"=>$eventsAlert->id]) }}"
                                           class="text-primary">{{ $eventsAlert->title }}</a>
                                        <br>
                                        <small class="text-muted">
                                            @if($eventsAlert->type ==3 || $eventsAlert->type ==2)
                                                {{ date('d M Y  h:i A', strtotime($eventsAlert->start_date)) }}
                                            @else
                                                {{ date('d M Y', strtotime($eventsAlert->start_date)) }}
                                            @endif
                                        </small>
                                    </span></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </li> -->
            @endif
            <!-- Navbar Dropdown -->
            <li class="nav-item dropdown pos-stc-xs">
                <a class="nav-link" data-toggle="dropdown">
                    <i class="material-icons">&#xe7f5;</i>
                    <span class="label label-sm up warn" style="display:none">0</span>
                </a>
                <div class="dropdown-menu pull-right w-xl animated fadeInUp no-bg no-border no-shadow">
                    <div class="box dark">
                        <div class="box-header p-a clearfix">
                            <strong>Notifications</strong>
                            <button onclick="NM.seenAll()"
                                    class="btn btn-xs btn-default pull-right">
                                Clear All
                            </button>
                        </div>
                        <div class="box p-a scrollable maxHeight320">
                            <ul class="list-group list-group-gap m-a-0" id="notif-list"></ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link clear" data-toggle="dropdown">
                  <span class="avatar w-32">
                      @if(Auth::user()->photo !="")
                          <img src="{{ asset('uploads/users/'.Auth::user()->photo) }}" alt="{{ Auth::user()->name }}"
                               title="{{ Auth::user()->name }}">
                      @else
                          <img src="{{ asset('uploads/contacts/profile.jpg') }}" alt="{{ Auth::user()->name }}"
                               title="{{ Auth::user()->name }}">
                      @endif
                      <i class="on b-white bottom"></i>
                  </span>
                </a>
                <div class="dropdown-menu pull-right dropdown-menu-scale ">
                    @if(Helper::GeneralWebmasterSettings("inbox_status"))
                        @if(@Auth::user()->permissionsGroup->inbox_status)
                            <a class="dropdown-item"
                               href="{{ route('webmails') }}"><span>{{ __('backend.siteInbox') }}</span>
                                @if( @$webmailsNewCount >0)
                                    <span class="label warn m-l-xs">{{ @$webmailsNewCount }}</span>
                                @endif
                            </a>
                        @endif
                    @endif
                    @if(Auth::user()->permissions ==0 || Auth::user()->permissions ==1)
                        <a class="dropdown-item"
                           href="{{ route('usersEdit',Auth::user()->id) }}"><span>{{ __('backend.profile') }}</span></a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('adminLogout') }}">{{ __('backend.logout') }}</a>
                </div>
            </li>

            <li class="nav-item hidden-md-up">
                <a class="nav-link" data-toggle="collapse" data-target="#collapse">
                    <i class="material-icons">&#xe5d4;</i>
                </a>
            </li>
        </ul>

        <!-- navbar collapse -->
        <div class="collapse navbar-toggleable-sm" id="collapse">
            @if(Route::currentRouteName() !="adminSearch")
                {{Form::open(['route'=>['adminSearch'],'method'=>'GET', 'role'=>'search', 'class' => "navbar-form form-inline pull-right pull-none-sm navbar-item v-m" ])}}

                <div class="form-group l-h m-a-0">
                    <div class="input-group"><input type="text" name="q" class="form-control p-x" autocomplete="off"
                                                    placeholder="{{ __('backend.search') }}...">
                        <span
                            class="input-group-btn"><button type="submit" class="btn white b-a no-shadow"><i
                                    class="fa fa-search"></i></button></span></div>
                </div>
                {{Form::close()}}
            @endif

            @if(Helper::GeneralWebmasterSettings("license") && Helper::GeneralWebmasterSettings("purchase_code")!="")
                @if(@Auth::user()->permissionsGroup->add_status)
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown pa-13">
                            <a class="btn light" data-toggle="dropdown">
                                <i class="material-icons">&#xe145;</i>
                                <span>{{ __('backend.new') }} </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-scale">
                                <?php
                                $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
                                $clr_ary = array("info", "danger", "success", "accent",);
                                $ik = 0;
                                $mnu_title_var = "title_" . @Helper::currentLanguage()->code;
                                $mnu_title_var2 = "title_" . config('smartend.default_language');
                                ?>
                                @if(@Auth::user()->permissionsGroup->add_status)
                                    @foreach($GeneralWebmasterSections as $headerWebmasterSection)
                                        @if(in_array($headerWebmasterSection->id,$data_sections_arr))
                                            <?php
                                            if ($headerWebmasterSection->$mnu_title_var != "") {
                                                $GeneralWebmasterSectionTitle = $headerWebmasterSection->$mnu_title_var;
                                            } else {
                                                $GeneralWebmasterSectionTitle = $headerWebmasterSection->$mnu_title_var2;
                                            }
                                            $LiIcon = "&#xe2c8;";
                                            if ($headerWebmasterSection->type == 3) {
                                                $LiIcon = "&#xe050;";
                                            }
                                            if ($headerWebmasterSection->type == 2) {
                                                $LiIcon = "&#xe63a;";
                                            }
                                            if ($headerWebmasterSection->type == 1) {
                                                $LiIcon = "&#xe251;";
                                            }
                                            if ($headerWebmasterSection->type == 0) {
                                                $LiIcon = "&#xe2c8;";
                                            }
                                            if ($headerWebmasterSection->id == 1) {
                                                $LiIcon = "&#xe3e8;";
                                            }
                                            if ($headerWebmasterSection->id == 7) {
                                                $LiIcon = "&#xe02f;";
                                            }
                                            if ($headerWebmasterSection->id == 2) {
                                                $LiIcon = "&#xe540;";
                                            }
                                            if ($headerWebmasterSection->id == 3) {
                                                $LiIcon = "&#xe307;";
                                            }
                                            if ($headerWebmasterSection->id == 8) {
                                                $LiIcon = "&#xe8f6;";
                                            }

                                            ?>
                                            <a class="dropdown-item"
                                               href="{{route("topicsCreate",$headerWebmasterSection->id)}}"><span><i
                                                        class="material-icons">{!! $LiIcon !!}</i> &nbsp;{!! $GeneralWebmasterSectionTitle !!}</span></a>
                                        @endif
                                    @endforeach

                                    @if(@Auth::user()->permissionsGroup->banners_status)
                                        <a class="dropdown-item" href="{{route("Banners")}}"><i class="material-icons">
                                                &#xe433;</i>
                                            &nbsp;{{ __('backend.adsBanners') }}</a>
                                    @endif
                                    <div class="dropdown-divider"></div>

                                    @if(Helper::GeneralWebmasterSettings("newsletter_status"))
                                        @if(@Auth::user()->permissionsGroup->newsletter_status)
                                            <a class="dropdown-item" href="{{route("contacts")}}"><i
                                                    class="material-icons">
                                                    &#xe7ef;</i>
                                                &nbsp;{{ __('backend.newContacts') }}</a>
                                        @endif
                                    @endif
                                @endif
                                @if(Helper::GeneralWebmasterSettings("inbox_status"))
                                    @if(@Auth::user()->permissionsGroup->inbox_status)
                                        <a class="dropdown-item"
                                           href="{{ route("webmails",["group_id"=>"create"]) }}"><i
                                                class="material-icons">&#xe0be;</i> &nbsp;{{ __('backend.compose') }}
                                        </a>
                                    @endif
                                @endif

                            </div>
                        </li>
                    </ul>
                @endif
            @else
                <ul class="nav navbar-nav" style="display:none;">
                    <li class="nav-item">
                        <div class="pa-13">
                            <strong class="inline-block text-danger">{{ __('backend.unlicensed') }}</strong> &nbsp;
                            <a href="{{ route("webmasterSettings") }}?tab=license"
                               class="btn btn danger">{{ __('backend.licenseNow') }}</a>
                        </div>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>
<script>
window._userId    = {{ auth()->id() }};
window._csrfToken = document.querySelector('meta[name="csrf-token"]').content;

const actionBg = { created: '#e8f5e9', updated: '#fff8e1', deleted: '#ffebee' };

class NotificationManager {
    constructor() {
        this.count = 0;
        this.list  = document.getElementById('notif-list');
        this.badge = document.querySelector('.label.warn');
        this.init();
    }

    async init() {
        await this.load();
        this.connect();
    }

    async load() {
        const data = await fetch('/notifications').then(r => r.json());
        this.count = data.count;
        this.updateBadge();
        if (data.notifications.length === 0) {
            this.showEmpty();
        } else {
            data.notifications.forEach(n => this.addItem(n, false));
        }
    }

    connect() {
        const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
            cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
            forceTLS:     true,
            authEndpoint: '/broadcasting/auth',
            auth: { headers: { 'X-CSRF-TOKEN': window._csrfToken } }
        });

        window.Echo = new Echo({ broadcaster: 'pusher', client: pusher });

        window.Echo.private(`notifications.${window._userId}`)
            .listen('NotificationCreated', ({ notification }) => {
                this.removeEmpty();
                this.count++;
                this.updateBadge();
                this.addItem(notification, true);
            })
            .listen('NotificationSeen', ({ notificationId }) => {
                notificationId === 'all' ? this.removeAll() : this.removeOne(notificationId);
            });
    }

    addItem(n, animate) {
        const li      = document.createElement('li');
        li.className  = 'list-group-item lt box-shadow-z0 b';
        li.dataset.id = n.id;
        li.innerHTML  = `
            <span class="clear block">
                <i class="material-icons" style="font-size:15px;vertical-align:middle">${n.icon || 'notifications'}</i>
                <strong> ${n.title}</strong><br>
                <small>${n.message}</small><br>
                <small class="text-muted">${n.time || 'এইমাত্র'}</small>
                ${n.url ? `<a href="${n.url}" onclick="NM.seen(${n.id})"
                    class="btn btn-xs btn-default pull-right m-t-xs">দেখুন</a>` : ''}
            </span>`;

        if (animate) {
            li.style.background = actionBg[n.action] || '#fffde7';
            setTimeout(() => li.style.transition = 'background 1.5s', 50);
            setTimeout(() => li.style.background = '', 2500);
        }

        this.list.prepend(li);
    }

    async seen(id) {
        this.removeOne(id);
        await fetch(`/notifications/${id}/seen`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': window._csrfToken }
        });
    }

    async seenAll() {
        this.removeAll();
        await fetch('/notifications/seen-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': window._csrfToken }
        });
    }

    removeOne(id) {
        document.querySelector(`#notif-list [data-id="${id}"]`)?.remove();
        this.count = Math.max(0, this.count - 1);
        this.updateBadge();
        if (!this.list.querySelector('[data-id]')) this.showEmpty();
    }

    removeAll() {
        this.list.querySelectorAll('[data-id]').forEach(el => el.remove());
        this.count = 0;
        this.updateBadge();
        this.showEmpty();
    }

    updateBadge() {
        if (!this.badge) return;
        this.badge.textContent   = this.count;
        this.badge.style.display = this.count > 0 ? 'inline' : 'none';
    }

    showEmpty() {
        if (!this.list.querySelector('.notif-empty')) {
            this.list.innerHTML =
                '<li class="list-group-item text-muted text-center notif-empty">কোনো notification নেই</li>';
        }
    }

    removeEmpty() {
        this.list.querySelector('.notif-empty')?.remove();
    }
}

window.NM = new NotificationManager();
</script>