<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Navbar (top) Module
///////////////////////////////////////////////////////////////////////////////
$lastFew = sqlRequest( "SELECT *, DATE_FORMAT(timesent, '%I %p') AS timesent2 FROM messages WHERE recipientid = " . $data['user']->getId() . " LIMIT 5" );
$messagesNumUnread  = sqlRequest("SELECT COUNT(messages.id) AS totalnum FROM messages WHERE viewed IS FALSE AND recipientid = {$data['user']->getId()}")[0]['totalnum'];
?>
        <!-- ===== Top-Navigation ===== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="/Account/dashboard/">
                        <b>
                            <img src="/images/logo.png" alt="home" />
                        </b>
                        <span>
                            <img src="/images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
                            <i class="icon-speech"></i>
<?php if ($messagesNumUnread ?? NULL) { if ($messagesNumUnread > 0) { ?>
                            <span class="badge badge-xs badge-danger"><?php echo $messagesNumUnread; ?></span>
<?php } } ?>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have <?php $messagesNumUnread = $messagesNumUnread ?? 0; echo $messagesNumUnread; ?> new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
<?php if ($lastFew ?? NULL) { foreach ($lastFew as $message)
      {
          // Message sender information
          $messageSender = sqlRequestArrayByID("users", $message['senderid'], '*');
?>
                                    <a href="/Messages/open/<?php echo $message['id']; ?>">
                                        <div class="user-img">
                                            <img src="/images/users/<?php
                                                if($messageSender['profilePic']){
                                                    echo $messageSender['profilePic'];
                                                }else {
                                                    echo 'avatar.png';
                                                }
                                            ?>" alt="user" class="img-circle">
                                            <span class="profile-status online pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5><?php if (!$message['viewed']) { echo '<strong>'; } echo "{$messageSender['namefirst']} {$messageSender['namelast']}"; if (!$message['viewed']) { echo '</strong>'; } ?></h5>
                                            <span class="mail-desc"><?php echo substr($message['message'], 0, 18); ?></span>
                                            <span class="time"><?php echo $message['timesent2']; ?></span>
                                        </div>
                                    </a>
<?php } } ?>
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="/Messages/inbox/">
                                    <strong>See all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- ===== Top-Navigation-End ===== -->
