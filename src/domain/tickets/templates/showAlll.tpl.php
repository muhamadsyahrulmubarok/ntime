<?php

defined('RESTRICTED') or die('Restricted access');
$sprints        = $this->get("sprints");
$searchCriteria = $this->get("searchCriteria");
$currentSprint  = $this->get("currentSprint");

$todoTypeIcons  = $this->get("ticketTypeIcons");

$efforts        = $this->get('efforts');
$statusLabels   = $this->get('allTicketStates');

//All states >0 (<1 is archive)
$numberofColumns = count($this->get('allTicketStates')) - 1;
$size = floor(100 / $numberofColumns);


?>

<style>
    #Sidebar {
        box-sizing: border-box;
        position: fixed;
        width: 37%;
        height: 500px;
        top: 80px;
        right: 0;
        transform: translateX(100%);
        /* border: 1px solid red; */
        transition: transform 2s;
        /* This is slow for demonstration purposes */
    }

    #Sidebar.open {
        transform: translateX(0);
    }

    ::-webkit-scrollbar {
        width: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #4c4c6a;
        border-radius: 2px;
    }

    aside,
    main header,
    main footer,
    .statuss,
    #chat {

        box-sizing: border-box;
    }


    #chatbox {
        width: 500px;
        height: 500px;
        background: #eff3f7;
        margin: 0 auto;
        font-size: 0;
        border-radius: 5px;
        overflow: hidden;
    }

    aside {
        width: 260px;
        height: 800px;
        background-color: #3b3e49;
        display: inline-block;
        font-size: 15px;
        vertical-align: top;
    }

    main {
        width: 490px;
        height: 800px;
        display: inline-block;
        font-size: 15px;
        vertical-align: top;
    }

    aside header {
        padding: 30px 20px;
    }

    aside input {
        width: 100%;
        height: 50px;
        line-height: 50px;
        padding: 0 50px 0 20px;
        background-color: #5e616a;
        border: none;
        border-radius: 3px;
        color: #fff;
        background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_search.png);
        background-repeat: no-repeat;
        background-position: 170px;
        background-size: 40px;
    }

    aside input::placeholder {
        color: #fff;
    }

    aside ul {
        padding-left: 0;
        margin: 0;
        list-style-type: none;
        overflow-y: scroll;
        height: 690px;
    }

    aside li {
        padding: 10px 0;
    }

    aside li:hover {
        background-color: #5e616a;
    }

    h2,
    h3 {
        margin: 0;
    }

    aside li img {
        border-radius: 50%;
        margin-left: 20px;
        margin-right: 8px;
    }

    aside li div {
        display: inline-block;
        vertical-align: top;
        margin-top: 12px;
    }

    aside li h2 {
        font-size: 14px;
        color: #fff;
        font-weight: normal;
        margin-bottom: 5px;
    }

    aside li h3 {
        font-size: 12px;
        color: #7e818a;
        font-weight: normal;
    }

    .statuss {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 7px;
    }

    .green {
        background-color: #58b666;
    }

    .orange {
        background-color: #ff725d;
    }

    .blue {
        background-color: #6fbced;
        margin-right: 0;
        margin-left: 7px;
    }

    main header {
        height: 70px;
        padding: 10px 10px 10px 10px;
    }

    main header>* {
        display: inline-block;
        vertical-align: top;
    }


    main header div {
        margin-left: 10px;
        margin-right: 145px;
    }

    main header h2 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    main header h3 {
        font-size: 14px;
        font-weight: normal;
        color: #7e818a;
    }

    #chat {
        padding-left: 0;
        margin: 0;
        list-style-type: none;
        overflow-y: scroll;
        height: 280px;
        border-top: 2px solid #fff;
        border-bottom: 2px solid #fff;
    }

    #chat li {
        padding: 10px 30px;
    }

    #chat h2,
    #chat h3 {
        display: inline-block;
        font-size: 13px;
        font-weight: normal;
    }

    #chat h3 {
        color: #bbb;
    }

    #chat .entete {
        margin-bottom: 5px;
    }

    #chat .message {
        padding: 10px;
        color: #fff;
        line-height: 25px;
        max-width: 90%;
        display: inline-block;
        text-align: left;
        border-radius: 5px;
    }

    #chat .me {
        text-align: right;
    }

    #chat .you .message {
        background-color: #58b666;
    }

    #chat .me .message {
        background-color: #6fbced;
    }

    #chat .triangle {
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 10px 10px 10px;
    }

    #chat .you .triangle {
        border-color: transparent transparent #58b666 transparent;
        margin-left: 15px;
    }

    #chat .me .triangle {
        border-color: transparent transparent #6fbced transparent;
        margin-left: 375px;
    }

    main footer {
        height: 155px;
        padding: 20px 30px 10px 20px;
    }

    main footer textarea {
        resize: none;
        border: none;
        display: block;
        width: 100%;
        height: 80px;
        border-radius: 3px;
        padding: 20px;
        font-size: 13px;
        margin-bottom: 13px;
    }

    main footer textarea::placeholder {
        color: #ddd;
    }

    main footer img {
        height: 30px;
        cursor: pointer;
    }

    main footer a {
        text-decoration: none;
        text-transform: uppercase;
        font-weight: bold;
        color: #6fbced;
        vertical-align: top;
        margin-left: 333px;
        margin-top: 5px;
        display: inline-block;
    }

    main header .close {
        position: relative;
        /* margin-left: -25px; */
        /* margin-top: -19px; */
        width: 32px;
        height: 32px;
        opacity: 0.3;
    }

    main header .close:hover {
        opacity: 1;
    }

    main header .close:before,
    main header .close:after {
        position: absolute;
        left: 15px;
        content: ' ';
        height: 25px;
        width: 2px;
        background-color: #333;
    }

    main header .close:before {
        transform: rotate(45deg);
    }

    main header .close:after {
        transform: rotate(-45deg);
    }
</style>
<div class="pageheader">
    <div class="pageicon"><span class="<?php echo $this->getModulePicture() ?>"></span></div>
    <div class="pagetitle">
        <h5><?php $this->e($_SESSION['currentProjectClient'] . " // " . $_SESSION['currentProjectName']); ?></h5>
        <h1><?php echo $this->__("headlines.todos"); ?></h1>
    </div>
</div>
<!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <?php echo $this->displayNotification(); ?>

        <form action="" method="get" id="ticketSearch">
            <input type="hidden" value="1" name="search" />
            <div class="row">
                <div class="col-md-5">
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $this->__("links.new_with_icon") ?> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="<?= BASE_URL ?>/tickets/newTicket"> <?= $this->__("links.add_todo") ?></a></li>
                            <li><a href="<?= BASE_URL ?>/tickets/editMilestone" class="milestoneModal"><?= $this->__("links.add_milestone") ?></a></li>
                            <li><a href="<?= BASE_URL ?>/sprints/editSprint" class="sprintModal"><?= $this->__("links.add_sprint") ?></a></li>
                        </ul>
                    </div>

                </div>

                <div class="col-md-2 center">
                    <span class="currentSprint">
                        <?php if ($this->get('sprints') !== false && count($this->get('sprints'))  > 0) { ?>
                            <select data-placeholder="<?= $this->__("input.placeholders.filter_by_sprint") ?>" title="<?= $this->__("input.placeholders.filter_by_sprint") ?>" name="sprint" class="mainSprintSelector" onchange="form.submit()" id="sprintSelect">
                                <option value="all" <?php if ($searchCriteria['sprint'] != "all") echo "selected='selected'"; ?>><?= $this->__("links.all_todos") ?></option>
                                <option value="backlog" <?php if ($searchCriteria['sprint'] == "backlog") echo "selected='selected'"; ?>><?= $this->__("links.backlog") ?></option>
                                <?php
                                $dates = "";
                                foreach ($this->get('sprints') as $sprintRow) {     ?>

                                    <?php echo "<option value='" . $sprintRow->id . "'";

                                    if ($this->get("currentSprint") !== false && $sprintRow->id == $this->get("currentSprint")) {
                                        echo " selected='selected' ";

                                        $dates = sprintf($this->__("label.date_from_date_to"), $this->getFormattedDateString($sprintRow->startDate), $this->getFormattedDateString($sprintRow->endDate));
                                    }
                                    echo ">";
                                    $this->e($sprintRow->name);
                                    echo "</option>";
                                    ?>

                                <?php }     ?>
                            </select>
                            <br />
                            <small>
                                <?php if ($dates != "") {
                                    echo $dates; ?> - <a href="<?= BASE_URL ?>/sprints/editSprint/<?= $this->get("currentSprint") ?>" class="sprintModal"><?= $this->__("links.edit_sprint") ?></a>
                                <?php } else { ?>
                                    <a href="<?= BASE_URL ?>/sprints/editSprint" class="sprintModal"><?= $this->__("links.create_sprint") ?></a>
                                <?php } ?>
                            </small>
                        <?php } ?>
                    </span>
                </div>
                <div class="col-md-5">
                    <div class="pull-right">

                        <div id="tableButtons" style="display:inline-block"></div>
                        <a onclick="leantime.ticketsController.toggleFilterBar();" class="btn btn-default"><?= $this->__("links.filter") ?></a>
                        <div class="btn-group viewDropDown">

                            <button class="btn dropdown-toggle" data-toggle="dropdown"><?= $this->__("links.group_by") ?></button>
                            <ul class="dropdown-menu">
                                <li><span class="radio"><input type="radio" name="groupBy" <?php if ($searchCriteria["groupBy"] == "") {
                                                                                                echo "checked='checked'";
                                                                                            } ?> value="" id="groupByNothingLink" onclick="jQuery('#ticketSearch').submit();" /><label for="groupByNothingLink"><?= $this->__("label.no_group") ?></label></span></li>
                                <li><span class="radio"><input type="radio" name="groupBy" <?php if ($searchCriteria["groupBy"] == "milestone") {
                                                                                                echo "checked='checked'";
                                                                                            } ?> value="milestone" id="groupByMilestoneLink" onclick="jQuery('#ticketSearch').submit();" /><label for="groupByMilestoneLink"><?= $this->__("label.milestone") ?></label></span></li>
                                <li><span class="radio"><input type="radio" name="groupBy" <?php if ($searchCriteria["groupBy"] == "user") {
                                                                                                echo "checked='checked'";
                                                                                            } ?> value="user" id="groupByUserLink" onclick="jQuery('#ticketSearch').submit();" /><label for="groupByUserLink"><?= $this->__("label.user") ?></label></span></li>
                                <li><span class="radio"><input type="radio" name="groupBy" <?php if ($searchCriteria["groupBy"] == "sprint") {
                                                                                                echo "checked='checked'";
                                                                                            } ?> value="sprint" id="groupBySprintLink" onclick="jQuery('#ticketSearch').submit();" /><label for="groupBySprintLink"><?= $this->__("label.sprint") ?></label></span></li>
                            </ul>

                        </div>

                        <div class="btn-group viewDropDown">
                            <button class="btn dropdown-toggle" data-toggle="dropdown"><?= $this->__("links.table") ?> <?= $this->__("links.view") ?></button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php if (isset($_SESSION['lastFilterdTicketKanbanView']) && $_SESSION['lastFilterdTicketKanbanView'] != "") {
                                                    echo $_SESSION['lastFilterdTicketKanbanView'];
                                                } else {
                                                    echo BASE_URL . "/tickets/showKanban";
                                                } ?>"><?= $this->__("links.kanban") ?></a></li>
                                <li><a href="<?php if (isset($_SESSION['lastFilterdTicketTableView']) && $_SESSION['lastFilterdTicketTableView'] != "") {
                                                    echo $_SESSION['lastFilterdTicketTableView'];
                                                } else {
                                                    echo BASE_URL . "/tickets/showAll";
                                                } ?>" class="active"><?= $this->__("links.table") ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="clearfix"></div>
            <div class="filterBar <?php if (!isset($_GET['search'])) {
                                        echo "hideOnLoad";
                                    } ?>">

                <div class="row-fluid">


                    <div class="filterBoxLeft">
                        <label class="inline"><?= $this->__("label.user") ?></label>
                        <div class="form-group">
                            <select data-placeholder="<?= $this->__("input.placeholders.filter_by_user") ?>" title="<?= $this->__("input.placeholders.filter_by_user") ?>" name="users" multiple="multiple" class="user-select" id="userSelect">
                                <option value=""></option>
                                <?php foreach ($this->get('users') as $userRow) {     ?>

                                    <?php echo "<option value='" . $userRow["id"] . "'";

                                    if ($searchCriteria['users'] !== false && $searchCriteria['users'] !== null && array_search($userRow["id"], explode(",", $searchCriteria['users'])) !== false) echo " selected='selected' ";

                                    echo ">" . sprintf($this->__('text.full_name'), $this->escape($userRow['firstname']), $this->escape($userRow['lastname'])) . "</option>"; ?>

                                <?php }     ?>
                            </select>
                        </div>

                    </div>
                    <div class="filterBoxLeft">

                        <label class="inline"><?= $this->__("label.milestone") ?></label>
                        <div class="form-group">
                            <select data-placeholder="<?= $this->__("input.placeholders.filter_by_milestone") ?>" title="<?= $this->__("input.placeholders.filter_by_milestone") ?>" name="milestone" id="milestoneSelect">
                                <option value=""><?= $this->__("label.all_milestones") ?></option>
                                <?php foreach ($this->get('milestones') as $milestoneRow) {     ?>

                                    <?php echo "<option value='" . $milestoneRow->id . "'";

                                    if (isset($searchCriteria['milestone']) && ($searchCriteria['milestone'] == $milestoneRow->id)) echo " selected='selected' ";

                                    echo ">" . $this->escape($milestoneRow->headline) . "</option>"; ?>

                                <?php }     ?>
                            </select>
                        </div>

                    </div>

                    <div class="filterBoxLeft">

                        <label class="inline"><?= $this->__("label.todo_type") ?></label>
                        <div class="form-group">
                            <select data-placeholder="<?= $this->__("input.placeholders.filter_by_tye") ?>" title="<?= $this->__("input.placeholders.filter_by_tye") ?>" name="type" id="typeSelect">
                                <option value=""><?= $this->__("label.all_types") ?></option>
                                <?php foreach ($this->get('types') as $type) {     ?>

                                    <?php echo "<option value='" . $type . "'";

                                    if (isset($searchCriteria['type']) && ($searchCriteria['type'] == $type)) echo " selected='selected' ";

                                    echo ">$type</option>"; ?>

                                <?php }     ?>
                            </select>
                        </div>

                    </div>

                    <div class="filterBoxLeft">
                        <label class="inline"><?= $this->__("label.todo_status") ?></label>
                        <div class="form-group">

                            <select data-placeholder="<?= $this->__("input.placeholders.filter_by_status") ?>" name="searchStatus" multiple="multiple" class="status-select" id="statusSelect">
                                <option value=""></option>
                                <option value="not_done" <?php if ($searchCriteria['status'] !== false && strpos($searchCriteria['status'], 'not_done') !== false) echo " selected='selected' "; ?>><?= $this->__("label.not_done") ?></option>
                                <?php foreach ($statusLabels as $key => $label) { ?>

                                    <?php echo "<option value='" . $key . "'";

                                    if ($searchCriteria['status'] !== false && array_search((string) $key, explode(",", $searchCriteria['status'])) !== false) echo " selected='selected' ";
                                    echo ">" . $this->escape($label["name"]) . "</option>"; ?>

                                <?php }     ?>
                            </select>
                        </div>

                    </div>

                    <div class="filterBoxLeft">
                        <label class="inline"><?= $this->__("label.search_term") ?></label><br />
                        <input type="text" class="form-control input-default" id="termInput" name="term" placeholder="<?= $this->__("input.placeholders.search") ?>" value="<?php $this->e($searchCriteria['term']); ?>">
                        <input type="submit" value="<?= $this->__("buttons.search") ?>" name="search" class="form-control btn btn-primary" />
                    </div>


                </div>

            </div>
        </form>

        <table id="allTicketsTable" class="table table-bordered display table-responsive">
            <colgroup>
                <col class="con1" width="20%">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
            </colgroup>
            <thead>
                <tr>
                    <th><?= $this->__("label.title"); ?></th>
                    <th><?= $this->__("label.todo_status"); ?></th>
                    <th class="milestone-col"><?= $this->__("label.milestone"); ?></th>
                    <th><?= $this->__("label.effort"); ?></th>
                    <th class="user-col"><?= $this->__("label.editor"); ?>.</th>
                    <th class="sprint-col"><?= $this->__("label.sprint"); ?></th>
                    <th class="duedate-col"><?= $this->__("label.due_date"); ?></th>
                    <th class="planned-hours-col"><?= $this->__("label.planned_hours"); ?></th>
                    <th class="remaining-hours-col"><?= $this->__("label.estimated_hours_remaining"); ?></th>
                    <th class="booked-hours-col"><?= $this->__("label.booked_hours"); ?></th>
                    <th class="booked-hours-col">Chat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->get('allTickets') as $row) { ?>
                    <tr>
                        <td data-order="<?= $this->e($row['headline']); ?>"><a href="<?= BASE_URL ?>/tickets/showTicket/<?= $this->e($row['id']); ?>"><?= $this->e($row['headline']); ?></a></td>
                        <td data-order="<?= $statusLabels[$row['status']]["name"] ?>">
                            <div class="dropdown ticketDropdown statusDropdown colorized show">
                                <a class="dropdown-toggle f-left status <?= $statusLabels[$row['status']]["class"] ?>" href="javascript:void(0);" role="button" id="statusDropdownMenuLink<?= $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text">
                                        <?php echo $statusLabels[$row['status']]["name"]; ?>
                                    </span>
                                    &nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdownMenuLink<?= $row['id'] ?>">
                                    <li class="nav-header border"><?= $this->__("dropdown.choose_status") ?></li>
                                    <?php foreach ($statusLabels as $key => $label) {
                                        echo "<li class='dropdown-item'>
                                            <a href='javascript:void(0);' class='" . $label["class"] . "' data-label='" . $this->escape($label["name"]) . "' data-value='" . $row['id'] . "_" . $key . "_" . $label["class"] . "' id='ticketStatusChange" . $row['id'] . $key . "' >" . $this->escape($label["name"]) . "</a>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </div>
                        </td>



                        <?php
                        if ($row['dependingTicketId'] != "" && $row['dependingTicketId'] != 0) {
                            $milestoneHeadline = $this->escape($row['milestoneHeadline']);
                        } else {
                            $milestoneHeadline = $this->__("label.no_milestone");
                        } ?>

                        <td data-order="<?= $milestoneHeadline ?>">
                            <div class="dropdown ticketDropdown milestoneDropdown colorized show">
                                <a style="background-color:<?= $this->escape($row['milestoneColor']) ?>" class="dropdown-toggle f-left  label-default milestone" href="javascript:void(0);" role="button" id="milestoneDropdownMenuLink<?= $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text"><?= $milestoneHeadline ?></span>
                                    &nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="milestoneDropdownMenuLink<?= $row['id'] ?>">
                                    <li class="nav-header border"><?= $this->__("dropdown.choose_milestone") ?></li>
                                    <li class='dropdown-item'><a style='background-color:#1b75bb' href='javascript:void(0);' data-label="<?= $this->__("label.no_milestone") ?>" data-value='<?= $row['id'] . "_0_#1b75bb" ?>'> <?= $this->__("label.no_milestone") ?> </a></li>

                                    <?php foreach ($this->get('milestones') as $milestone) {
                                        echo "<li class='dropdown-item'>
                                            <a href='javascript:void(0);' data-label='" . $this->escape($milestone->headline) . "' data-value='" . $row['id'] . "_" . $milestone->id . "_" . $this->escape($milestone->tags) . "' id='ticketMilestoneChange" . $row['id'] . $milestone->id . "' style='background-color:" . $this->escape($milestone->tags) . "'>" . $this->escape($milestone->headline) . "</a>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </div>
                        </td>
                        <td data-order="<?= $row['storypoints'] ? $efforts[$row['storypoints']] : $this->__("label.story_points_unkown"); ?>">
                            <div class="dropdown ticketDropdown effortDropdown show">
                                <a class="dropdown-toggle f-left  label-default effort" href="javascript:void(0);" role="button" id="effortDropdownMenuLink<?= $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text"><?php
                                                        if ($row['storypoints'] != '' && $row['storypoints'] > 0) {
                                                            echo $efforts[$row['storypoints']];
                                                        } else {
                                                            echo $this->__("label.story_points_unkown");
                                                        } ?>
                                    </span>
                                    &nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="effortDropdownMenuLink<?= $row['id'] ?>">
                                    <li class="nav-header border"><?= $this->__("dropdown.how_big_todo") ?></li>
                                    <?php foreach ($efforts as $effortKey => $effortValue) {
                                        echo "<li class='dropdown-item'>
                                                                        <a href='javascript:void(0);' data-value='" . $row['id'] . "_" . $effortKey . "' id='ticketEffortChange" . $row['id'] . $effortKey . "'>" . $effortValue . "</a>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </div>
                        </td>
                        <td data-order="<?= $row["editorFirstname"] != "" ?  $this->escape($row["editorFirstname"]) : $this->__("dropdown.not_assigned") ?>">
                            <div class="dropdown ticketDropdown userDropdown noBg show ">
                                <a class="dropdown-toggle f-left" href="javascript:void(0);" role="button" id="userDropdownMenuLink<?= $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text">
                                        <?php if ($row["editorFirstname"] != "") {
                                            echo "<span id='userImage" . $row['id'] . "'><img src='" . BASE_URL . "/api/users?profileImage=" . $row['editorProfileId'] . "' width='25' style='vertical-align: middle; margin-right:5px;'/></span><span id='user" . $row['id'] . "'>" . $this->escape($row["editorFirstname"]) . "</span>";
                                        } else {
                                            echo "<span id='userImage" . $row['id'] . "'><img src='" . BASE_URL . "/api/users?profileImage=false' width='25' style='vertical-align: middle; margin-right:5px;'/></span><span id='user" . $row['id'] . "'>" . $this->__("dropdown.not_assigned") . "</span>";
                                        } ?>
                                    </span>
                                    &nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdownMenuLink<?= $row['id'] ?>">
                                    <li class="nav-header border"><?= $this->__("dropdown.choose_user") ?></li>

                                    <?php foreach ($this->get('users') as $user) {
                                        echo "<li class='dropdown-item'>";
                                        echo "<a href='javascript:void(0);' data-label='" . sprintf($this->__("text.full_name"), $this->escape($user["firstname"]), $this->escape($user['lastname'])) . "' data-value='" . $row['id'] . "_" . $user['id'] . "_" . $user['profileId'] . "' id='userStatusChange" . $row['id'] . $user['id'] . "' ><img src='" . BASE_URL . "/api/users?profileImage=" . $user['profileId'] . "' width='25' style='vertical-align: middle; margin-right:5px;'/>" . sprintf($this->__("text.full_name"), $this->escape($user["firstname"]), $this->escape($user['lastname'])) . "</a>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </div>
                        </td>
                        <?php

                        if ($row['sprint'] != "" && $row['sprint'] != 0  && $row['sprint'] != -1) {
                            $sprintHeadline = $this->escape($row['sprintName']);
                        } else {
                            $sprintHeadline = $this->__("label.backlog");
                        } ?>

                        <td data-order="<?= $sprintHeadline ?>">

                            <div class="dropdown ticketDropdown sprintDropdown show">
                                <a class="dropdown-toggle f-left  label-default sprint" href="javascript:void(0);" role="button" id="sprintDropdownMenuLink<?= $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text"><?= $sprintHeadline ?></span>
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sprintDropdownMenuLink<?= $row['id'] ?>">
                                    <li class="nav-header border"><?= $this->__("dropdown.choose_sprint") ?></li>
                                    <li class='dropdown-item'><a href='javascript:void(0);' data-label="<?= $this->__("label.backlog") ?>" data-value='<?= $row['id'] . "_0" ?>'> <?= $this->__("label.backlog") ?> </a></li>
                                    <?php if ($this->get('sprints')) {
                                        foreach ($this->get('sprints') as $sprint) {
                                            echo "<li class='dropdown-item'>
                                                    <a href='javascript:void(0);' data-label='" . $this->escape($sprint->name) . "' data-value='" . $row['id'] . "_" . $sprint->id . "' id='ticketSprintChange" . $row['id'] . $sprint->id . "' >" . $this->escape($sprint->name) . "</a>";
                                            echo "</li>";
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </td>

                        <?php
                        if ($row['dateToFinish'] == "0000-00-00 00:00:00" || $row['dateToFinish'] == "1969-12-31 00:00:00") {
                            $date = $this->__("text.anytime");
                        } else {
                            $date = new DateTime($row['dateToFinish']);
                            $date = $date->format($this->__("language.dateformat"));
                        }
                        ?>
                        <td data-order="<?= $date ?>">


                            <?php echo $this->__("label.due_icon"); ?><input type="text" title="<?php echo $this->__("label.due"); ?>" value="<?php echo $date ?>" class="duedates secretInput" data-id="<?php echo $row['id']; ?>" name="date" />

                        </td>
                        <td data-order="<?= $this->e($row['planHours']); ?>">
                            <input type="text" value="<?= $this->e($row['planHours']); ?>" name="planHours" class="small-input" onchange="leantime.ticketsController.updatePlannedHours(this, '<?= $row['id'] ?>'); jQuery(this).parent().attr('data-order',jQuery(this).val());" />
                        </td>
                        <td data-order="<?= $this->e($row['hourRemaining']); ?>">
                            <input type="text" value="<?= $this->e($row['hourRemaining']); ?>" name="remainingHours" class="small-input" onchange="leantime.ticketsController.updateRemainingHours(this, '<?= $row['id'] ?>');" />
                        </td>

                        <td data-order="<?php if ($row['bookedHours'] === null || $row['bookedHours'] == "") echo "0";
                                        else echo $row['bookedHours'] ?>">

                            <?php if ($row['bookedHours'] === null || $row['bookedHours'] == "") echo "0";
                            else echo $row['bookedHours'] ?>
                        </td>
                        <td>
                            <a href="javacript:;" onclick="chatButton(<?php echo $row['id']; ?>)" id="<?php echo $row['id']; ?>" class="chatButton ChatGroup"><span class="far fa-chat"></span>Chat</a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <div id="Sidebar">
            <div id="chatbox">
                <main>
                    <header>
                        <a href="javacript:;" class="close" id="closeButton"></a>
                        <!-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg" alt=""> -->
                        <div>
                            <h2>Chat with Vincent Porter</h2>
                            <h3>already 1902 messages</h3>
                        </div>
                        <!-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png" alt=""> -->
                    </header>
                    <ul id="chat">
                        <li class="you">
                            <div class="entete">
                                <span class="statuss green"></span>
                                <h2>Vincent</h2>
                                <h3>10:12AM, Today</h3>
                            </div>
                            <div class="triangle"></div>
                            <div class="message">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                            </div>
                        </li>
                        <li class="you">
                            <div class="entete">
                                <span class="statuss green"></span>
                                <h2>Vincent</h2>
                                <h3>10:12AM, Today</h3>
                            </div>
                            <div class="triangle"></div>
                            <div class="message">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                            </div>
                        </li>
                        <li class="you">
                            <div class="entete">
                                <span class="statuss green"></span>
                                <h2>Vincent</h2>
                                <h3>10:12AM, Today</h3>
                            </div>
                            <div class="triangle"></div>
                            <div class="message">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                            </div>
                        </li>

                    </ul>
                    <footer>
                        <textarea placeholder="Type your message"></textarea>
                        <a href="#" style="float: right;">Send</a>
                    </footer>
                </main>
            </div>
        </div>
        <script>
            function chatButton(id) {

                var sidebar = document.getElementById("Sidebar");
                // console.log(sidebar)
                if (sidebar.classList.contains("open"))
                    sidebar.classList.remove("open");
                else
                    sidebar.classList.add("open");
            }


            document.getElementById("closeButton").addEventListener("click", function(e) {
                var sidebar = document.getElementById("Sidebar");
                // console.log(sidebar)
                if (sidebar.classList.contains("open"))
                    sidebar.classList.remove("open");
                else
                    sidebar.classList.add("open");

            });
        </script>

    </div>

</div>

<script type="text/javascript">
    leantime.ticketsController.initTicketSearchSubmit("<?= BASE_URL ?>/tickets/showAll");

    leantime.ticketsController.initUserDropdown();
    leantime.ticketsController.initMilestoneDropdown();
    leantime.ticketsController.initEffortDropdown();
    // leantime.ticketsController.initChatGroup();
    leantime.ticketsController.initStatusDropdown();
    leantime.ticketsController.initSprintDropdown();
    leantime.ticketsController.initUserSelectBox();
    leantime.ticketsController.initStatusSelectBox();


    leantime.ticketsController.initTicketsTable("<?= $searchCriteria["groupBy"] ?>");

    <?php if (isset($_SESSION['userdata']['settings']["modals"]["backlog"]) === false || $_SESSION['userdata']['settings']["modals"]["backlog"] == 0) {     ?>
        leantime.helperController.showHelperModal("backlog");
    <?php
        //Only show once per session
        $_SESSION['userdata']['settings']["modals"]["backlog"] = 1;
    } ?>
</script>