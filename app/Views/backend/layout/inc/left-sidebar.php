<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?= base_url('admin/home') ?>">
			<img src="/backend/vendors/images/logo.png" alt="" class="dark-logo" />
			<img src="/backend/vendors/images/logo.png" alt="" class="light-logo" />
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<?php if (App\Libraries\CIAuth::userType() === 'lecturer'): ?>
					<li>
						<a href="<?= base_url('admin/home') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/attachment/get') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user1"></span><span class="mtext">Attached Students</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/attachment/my-students') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-group"></span><span class="mtext">My Students</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/attachment/my-schedule') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-calendar"></span><span class="mtext">My Schedule</span>
						</a>
					</li>
					
					<?php if (App\Libraries\CIAuth::userType() === 'lecturer' && App\Libraries\CIAuth::role() === "1" | App\Libraries\CIAuth::role() === "2"): ?>

					<li>
						<a href="<?= base_url('/admin/get-users') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">Lecturers</span>
						</a>
					</li>

					<li>
						<a href="<?= base_url('admin/roles') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-id-card"></span><span class="mtext">Roles</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('admin/school') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-library"></span><span class="mtext">Schools</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('admin/courses') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-book"></span><span class="mtext">Courses</span>
						</a>
					</li>
					
					<li>
						<a href="<?= base_url('admin/logs') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-analytics-21"></span><span class="mtext">System Logs</span>
						</a>
					</li>
					<?php endif ?>

				<?php endif ?>

				<?php if (App\Libraries\CIAuth::userType() === 'student'): ?>
					<li>
						<a href="<?= base_url('/admin/attachmentlist') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/students/attachment/create') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-add-file"></span><span class="mtext">Add Attachment Details</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/attachment/attachment-details') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-information"></span><span class="mtext">My Attachment Details</span>
						</a>
					</li>
				<?php endif ?>

				<div class="dropdown-divider"></div>
				<li>
					<div class="sidebar-small-cap">Settings</div>
				</li>

				<?php if (App\Libraries\CIAuth::userType() === 'student'): ?>
					<li>
						<a href="<?= base_url('/admin/studentsprofile') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user-13"></span>
							<span class="mtext">My Profile</span>
						</a>
					</li>
				<?php endif ?>

				<?php if (App\Libraries\CIAuth::userType() === 'lecturer'): ?>
					<li>
						<a href="<?= base_url('/admin/profile') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user1"></span>
							<span class="mtext">Profile</span>
						</a>
					</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
</div>