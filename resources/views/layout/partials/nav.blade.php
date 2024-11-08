<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="index">
            <img src="assets/img/logo-icon.png" class="img-fluid" alt="">
        </a>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ Request::is('index') ? 'active' : '' }}">
                    <a href="index"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
                </li>

				<li class="submenu">
					<a href="#"><i class="fas fa-border-all"></i> <span>Company</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<!-- Add Company Link -->
						<li>
							<a class="{{ Request::is('companies/create') ? 'active' : '' }}" href="{{ route('companies.create') }}">
								Add Company
							</a>
						</li>
						<!-- Company List Link -->
						<li>
							<a class="{{ Request::is('companies') ? 'active' : '' }}" href="{{ route('companies.index') }}">
								Company List
							</a>
						</li>
					</ul>
				</li>
				

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
