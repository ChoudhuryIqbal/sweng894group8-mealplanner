<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Sidebar Module
///////////////////////////////////////////////////////////////////////////////

?>
        <!-- ===== Left-Sidebar ===== -->
        <aside class="sidebar">
            <div class="scroll-sidebar">
                <div class="user-profile">
                    <div class="dropdown user-pro-body">
                        <div class="profile-image">
                            <img src="/images/users/<?php echo $data['user']->getUsername().".jpg"; ?>" alt="user-img" class="img-circle">
                            <a href="javascript:void(0);" class="dropdown-toggle u-dropdown text-blue" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="badge badge-danger">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated flipInY">
                                <li><a href="javascript:void(0);"><i class="fa fa-user"></i> Profile</a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-inbox"></i> Inbox</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/Account/settings"><i class="fa fa-cog"></i> Account Settings</a></li>
                                <li><a href="/Household/list"><i class="fa fa-cog"></i> Household Settings</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/Account/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                        <p class="profile-text m-t-15 font-16"><a href="javascript:void(0);"><?php echo $data['user']->getFirstName(); echo ' ' . $data['user']->getLastName() ?></a></p>
                    </div>
                </div>
                <nav class="sidebar-nav">
                    <ul id="side-menu">
                        <li>
                            <a class="waves-effect" href="/Account/dashboard/"><i class="icon-screen-desktop fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-cup fa-fw"></i> <span class="hide-menu"> Food<span class="label label-rounded label-success pull-right">2</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/FoodItems/index">Food List</a></li>
                                <li><a href="/FoodItems/create">Add Food Item</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-note"></i> <span class="hide-menu"> Recipes<span class="label label-rounded label-danger pull-right">2</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/Recipes/index">Recipe List</a></li>
                                <li><a href="/Recipes/create">Add Recipe</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-book-open fa-fw"></i> <span class="hide-menu"> Meals<span class="label label-rounded label-danger pull-right">0</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/Meals/index">Meal List</a></li>
                                <li><a href="/Meals/create">Add Meal</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-book-open fa-fw"></i> <span class="hide-menu"> Groceries<span class="label label-rounded label-danger pull-right">0</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/Groceries/index">View Grocery List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-
expanded="false"><i class="icon-envelope-letter fa-fw"></i> <span class="hide-menu"> Inbox<span class="label label-rounded label-<?php if ($NumUnread ?? 0) { echo 'success'; } else { echo 'info'; } ?> pull-right"><?php echo number_format($NumUnread ?? 0); ?></span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/Messages/inbox/">Inbox</a></li>
                                <li><a href="/Messages/outbox/">Sent Messages</a></li>
                                <li><a href="/Messages/compose/">Compose</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- ===== Left-Sidebar-End ===== -->
