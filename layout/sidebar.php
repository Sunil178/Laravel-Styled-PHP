<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="/assets/img/aceaffilino-logo.jpg" alt=""
                    style="width: 6%; margin: 6px; margin-left: 37px;">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">AceAffilino</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <li class="menu-item open">
            <div class="fw-semibold menu-link">
                <img src="/assets/img/profile.png" class="w-px-30 menu-icon" />
                <span data-i18n="Analytics" class="text-info"><?php echo $_SESSION["employee_name"] ?? 'User'; ?></span>
            </div>
        </li>
        <?php if (!checkAuth()) { ?>
            <li class="menu-item open">
                <a href="/login" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-log-in-circle"></i>
                    <div data-i18n="Analytics">Login to access</div>
                </a>
            </li>
        <?php } ?>

        <?php if (checkAuth()) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-target-lock"></i>
                    <div data-i18n="Analytics">Targets</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/targets" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/targets/leads" class="menu-link">
                            <div data-i18n="Without menu">Leads</div>
                        </a>
                    </li>
                    <?php if (checkAuth(true)) { ?>
                        <li class="menu-item">
                            <a href="/targets/create" class="menu-link">
                                <div data-i18n="Without menu">Create</div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth(true)) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Bot Leads</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/bot/index" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth()) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-android"></i>
                    <div data-i18n="Analytics">Leads</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/leads" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/leads/create" class="menu-link">
                            <div data-i18n="Without menu">Create</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth()) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dice-6"></i>
                    <div data-i18n="Analytics">Gameplays</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/gameplays" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/gameplays/create" class="menu-link">
                            <div data-i18n="Without menu">Create</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth()) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-memory-card"></i>
                    <div data-i18n="Analytics">SIMs</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/sims" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth(true)) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Employees</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/employees" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/employees/create" class="menu-link">
                            <div data-i18n="Without menu">Create</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <?php if (checkAuth(true)) { ?>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-business"></i>
                    <div data-i18n="Analytics">Campaigns</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/acampaigns" class="menu-link">
                            <div data-i18n="Without menu">Index</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/acampaigns/create" class="menu-link">
                            <div data-i18n="Without menu">Create</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

    </ul>
</aside>
