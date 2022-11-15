<div id="ct_admin_settings_page">
    <section class="page_title_background">
        <div class="page_title">
            <h2>
                Settings
            </h2>
        </div>
    </section>

    <section class="container">
        <!-- Countdown Timer Settings -->
        <div class="grid">
            <div class="countdown_title">
                <div class="countdown_box">
                    <h3>Countdown Settings</h3>
                    <p>Update your product global countdown timer information.</p>
                </div>
                <div class="empty_div"></div>
            </div>

            <form class="form" action="admin.php?page=genuine_style_countdown_timer" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="setting" value="countdown">
                <div class="form_body_1">
                    <div class="form_body_grid">

                        <!-- Enabled -->
                        <div class="form_body_part">
                            <label class="label" for="enabled">Enabled?</label>
                            <div>
                                <?php if(isset($settings['Countdown Settings']['enabled'])): ?>
                                    <label>
                                        <input type="radio" <?= $settings['Countdown Settings']['enabled'] == 1 ? "checked" : "" ?> name="enabled" value="1">
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" <?= $settings['Countdown Settings']['enabled'] == 0 ? "checked" : "" ?> name="enabled" value="0">
                                        No
                                    </label>
                                <?php else: ?>
                                    <label>
                                        <input type="radio" name="enabled" value="1">
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="enabled" value="0">
                                        No
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Cut-off Time -->
                        <div class="form_body_part">
                            <label class="label" for="name">Cut-off Time</label>
                            <input name="cut_off_time" type="time" value="<?= $settings['Countdown Settings']['cut_off_time'] ?>">
                        </div>

                        <!-- Shipping Days: -->
                        <div class="form_body_part">
                            <label class="label" for="name">Shipping Date</label>
                            <?php if(isset($settings['Countdown Settings']['countdown_offset'])): ?>
                                <select name="countdown_offset">
                                    <option <?= $settings['Countdown Settings']['countdown_offset'] == 0 ? "selected" : "" ?> value="0">Same Day</option>
                                    <option <?= $settings['Countdown Settings']['countdown_offset'] == 1 ? "selected" : "" ?> value="1">Next Day</option>
                                    <option <?= $settings['Countdown Settings']['countdown_offset'] == 2 ? "selected" : "" ?> value="2">2 Days</option>
                                    <option <?= $settings['Countdown Settings']['countdown_offset'] == 3 ? "selected" : "" ?> value="3">3 Days</option>
                                </select>
                            <?php else: ?>
                                <select name="countdown_offset">
                                    <option value="0">Same Day</option>
                                    <option value="1">Next Day</option>
                                    <option value="2">2 Days</option>
                                    <option value="3">3 Days</option>
                                </select>
                            <?php endif; ?>
                        </div>

                        <!-- Preview -->
                        <div class="form_body_part">
                            <label class="label" for="Preview">Preview</label>
                            <div id="ct_target" class="input"></div>
                        </div>
                    </div>
                </div>

                <div class="form_body_2">
                    <button type="submit" class="button">
                        Save
                    </button>
                </div>
            </form>
        </div>

        <!-- Holidays -->
        <div class="grid">
            <div class="countdown_title">
                <div class="countdown_box">
                    <h3>Holidays</h3>
                    <p>Update the holidays to let the software know when you're not delivering.</p>
                </div>
                <div class="empty_div"></div>
            </div>

            <div class="form" >
                <form action="admin.php?page=genuine_style_countdown_timer" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="setting" value="holidays">
                    <input type="hidden" name="id" value="<?= uniqid() ?>">
                    <div class="form_body_1">
                        <div class="form_body_grid">
                            <div class="form_body_part">
                                <label class="label" for="holiday_name">Name</label>
                                <input class="input" name="name" id="holiday_name" type="text">
                            </div>
                            <div class="form_body_part">
                                <label class="label" for="date">Date</label>
                                <input class="input" name="date" id="date" type="date">
                            </div>
                        </div>
                    </div>

                    <div class="form_body_2">
                        <button type="submit" class="button">
                            ADD
                        </button>
                    </div>
                </form>

                <table id="holiday_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($settings['Holidays Settings']) && !empty($settings['Holidays Settings'])): ?>
                            <?php foreach($settings['Holidays Settings'] as $setting): ?>
                                <tr class="text-xs is-checked font-semibold">
                                    <td class="py-2 border-2 px-3"><?= $setting['name'] ?></td>
                                    <td class="py-2 border-2 px-3"><?= $setting['date'] ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="delete" value="delete">
                                            <input type="hidden" name="id" value="<?= $setting['id'] ?>">
                                            <button class="button" style="display: flex;">
                                                <svg style="height: 1.25rem; fill: #fff; margin-top: auto; margin-bottom: auto;" class="h-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>