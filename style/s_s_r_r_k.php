<?php if ($server['startovan'] == "1") { ?>
    <li>
        <form action="process.php?task=restart_server" method="POST">
            <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
            <button class="restart_btn" style="background:none;border:none;">
                <i class="fa fa-refresh" style="font-size: 15px;"></i> Restart
            </button>
        </form>
    </li>
    <li>
        <form action="process.php?task=stop_server" method="POST">
            <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
            <button href="" class="stop_btn" style="background:none;border:none;">
                <i class="fa fa-power-off" style="font-size: 15px;"></i> Stop
            </button>
        </form>
    </li> 
<?php } else { ?>
    <li>
        <form action="process.php?task=start_server" method="POST">
            <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
            <button href="" class="start_btn" style="background:none;border:none;">
                <i class="fa fa-caret-right" style="font-size: 20px;"></i> Start
            </button>
        </form>
    </li> 
    
    <?php if (is_pin() == false) { ?>
        <li>
            <button class="restart_btn" style="background:none;border:none;" data-toggle="modal" data-target="#pin-auth">
                <i class="fa fa-refresh" style="font-size: 15px;"></i> Reinstall
            </button>
        </li>
    <?php } else { ?>
        <li>
            <form action="process.php?task=reinstall_server" method="POST">
                <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                <button class="restart_btn" style="background:none;border:none;">
                    <i class="fa fa-refresh" style="font-size: 15px;"></i> Reinstall
                </button>
            </form>
        </li>
        <li>
            <form action="process.php?task=obrisi_sve" method="POST">
                <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                <button class="kill_btn" style="background:none;border:none;">
                    <i class="fa fa-power-off" style="font-size: 15px;"></i> Kill
                </button>
            </form>
        </li>
    <?php } ?>
<?php } ?> 