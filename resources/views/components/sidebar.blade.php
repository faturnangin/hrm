        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                {{-- <a class="add-project-sidebar btn btn-primary" href="{{url('/subscription')}}">+ Subscribe</a> --}}
				<ul class="metismenu" id="menu">
                    <li>
                        <a href="{{url('/dashboard')}}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-layout"></i>
                        <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-plugin"></i>
							<span class="nav-text">Master Data</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('positions')}}">Job Title</a></li>
                            <li><a href="{{url('units')}}">Units</a></li>
                            <li><a href="{{url('users')}}">Employee</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{url('/log')}}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-statistics"></i>
                        <span class="nav-text">User Activities</span>
                        </a>
                    </li>
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
