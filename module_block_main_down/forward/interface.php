<?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
    <script src="<?= $General->arr_general['site'] ?>storage/assets/js/Sortable.min.js"></script>
<?php endif; ?>
<div class="ppulse__aside row">
    <div class="col-md-12">
        <div class="info-block__wrapper-global">
            <div class="info-block__wrapper" id="sortable-blocks">
                <?php if (empty($blocks)): ?>
                    <div class="ppulse__aside-block">
                        <a href="https://t.me/projpulse" class="ppulse__aside-sort" target="_blank">
                            <span class="ppulse__aside-airtext" style="color: #fff"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_exampleTitle'); ?></span>
                            <img src="/resources/img/logo/banner.png" alt="" loading="lazy">
                            <div class="ppulse__aside-button">
                                <svg>
                                    <use href="/resources/img/sprite.svg#tg"></use>
                                </svg>
                                <span class="ppulse__aside-button-text" style="color: #fff">
                                    <?= $Translate->get_translate_module_phrase('module_block_main_down', '_exampleDescription'); ?>
                                </span>
                            </div>
                        </a>
                        <?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
                            <div class="info-block__action">
                                <button onclick="event.preventDefault();" data-openmodal="addBlock">
                                    <svg>
                                        <use href="/resources/img/sprite.svg#plus"></use>
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($blocks as $block): ?>
                        <div class="ppulse__aside-block">
                            <a href="<?= $block['url'] ?>" data-blockid="<?= $block['id'] ?>" class="ppulse__aside-sort" style="background-image: linear-gradient(to right, <?= $block['color_bg_start'] ?>, <?= $block['color_bg_end'] ?>);" target="_blank">
                                <span class="ppulse__aside-airtext" style="color: <?= $block['color_text'] ?>"><?= $block['title'] ?></span>
                                <img src="/app/modules/module_block_main_down/assets/img/<?= $block['file'] ?>" alt="" loading="lazy">
                                <div class="ppulse__aside-button">
                                    <span class="ppulse__aside-button-text" style="color: <?= $block['color_text'] ?>">
                                        <?= $block['description'] ?>
                                    </span>
                                </div>
                                <?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
                                    <div class="info-block__action">
                                        <button onclick="event.preventDefault();" data-openmodal="editBlock<?= $block['id'] ?>">
                                            <svg>
                                                <use href="/resources/img/sprite.svg#gear"></use>
                                            </svg>
                                        </button>
                                        <button onclick="event.preventDefault();" id="del_block" data-block="<?= $block['id'] ?>">
                                            <svg>
                                                <use href="/resources/img/sprite.svg#trash"></use>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
                        <div class="ppulse__aside-block small filtered">
                            <a href="#" class="ppulse__aside-sort">
                                <img src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_down/assets/img/null-image.svg" alt="" loading="lazy">
                                <div class="info-block__action">
                                    <button onclick="event.preventDefault();" data-openmodal="addBlock">
                                        <svg>
                                            <use href="/resources/img/sprite.svg#plus"></use>
                                        </svg>
                                    </button>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php foreach ($blocks as $block): ?>
                <?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
                    <div class="popup_modal" id="editBlock<?= $block['id'] ?>">
                        <div class="popup_modal_content no-close no-scrollbar">
                            <form id="editBlockForm<?= $block['id'] ?>" method="post" enctype="multipart/form-data">
                                <input name="editBlock" value="<?= $block['id'] ?>" hidden>
                                <div class="popup_modal_head">
                                    <?= $Translate->get_translate_module_phrase('module_block_main_down', '_editingBanner'); ?>
                                    <span class="popup_modal_close">
                                        <svg>
                                            <use href="/resources/img/sprite.svg#x"></use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="inputs-inline">
                                    <label for="linkBlock<?= $block['id'] ?>"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_link'); ?></label>
                                    <input id="linkBlock<?= $block['id'] ?>" name="url" type="text" value="<?= $block['url'] ?>" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_linkPlaceholder'); ?>" required>
                                </div>
                                <div class="flex-inline">
                                    <div class="inputs-inline">
                                        <label for="titleBlock<?= $block['id'] ?>"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainText'); ?></label>
                                        <input id="titleBlock<?= $block['id'] ?>" name="title" value="<?= $block['title'] ?>" type="text" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainTextPlaceholder'); ?>" required>
                                    </div>
                                    <div class="inputs-inline">
                                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainTextColor'); ?></label>
                                        <input type="text" name="color_text" class="color_input" value="<?= $block['color_text'] ?>" data-jscolor="">
                                    </div>
                                </div>
                                <div class="inputs-inline">
                                    <label for="descriptionBlock"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_additionalText'); ?></label>
                                    <input id="descriptionBlock" name="description" type="text" value="<?= $block['description'] ?>" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_additionalTextPlaceholder'); ?>" required>
                                </div>
                                <hr>
                                <div class="flex-inline">
                                    <div class="inputs-inline">
                                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_initialBgColor'); ?></label>
                                        <input type="text" name="color_bg_start" class="color_input" value="<?= $block['color_bg_start'] ?>" data-jscolor="">
                                    </div>
                                    <div class="inputs-inline">
                                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_finalBgColor'); ?></label>
                                        <input type="text" name="color_bg_end" class="color_input" value="<?= $block['color_bg_end'] ?>" data-jscolor="">
                                    </div>
                                </div>
                                <hr>
                                <div class="inputs-inline">
                                    <div class="file-upload-container">
                                        <input type="file" form="editBlockForm<?= $block['id'] ?>" id="file-input<?= $block['id'] ?>" class="custom-file-input" accept="image/*" name="file">
                                        <label for="file-input<?= $block['id'] ?>"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_selectImage'); ?></label>
                                        <div id="file-info" class="file-upload-info file-info" style="display: block"><?= $block['file'] ?></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="ppulse__aside-block" id="infoBlockPreview" style="flex: none;">
                                    <a href="<?= $block['url'] ?>" class="ppulse__aside-sort" style="background-image: linear-gradient(to right, <?= $block['color_bg_start'] ?>, <?= $block['color_bg_end'] ?>);">
                                        <span class="ppulse__aside-airtext" style="color: <?= $block['color_text'] ?>" id="titlePreview"><?= $block['title'] ?></span>
                                        <img class="blockPreview" id="blockPreview" src="/app/modules/module_block_main_down/assets/img/<?= $block['file'] ?>" alt="" loading="lazy">
                                        <div class="ppulse__aside-button">
                                            <span class="ppulse__aside-button-text" style="color: <?= $block['color_text'] ?>" id="descriptionPreview"><?= $block['description'] ?></span>
                                        </div>
                                    </a>
                                </div>
                                <hr>
                                <button class="width-100" type="submit"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_editBanner'); ?></button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])): ?>
    <div class="popup_modal" id="addBlock">
        <div class="popup_modal_content no-close no-scrollbar">
            <form id="addBlockForm" method="post" enctype="multipart/form-data">
                <div class="popup_modal_head">
                    <?= $Translate->get_translate_module_phrase('module_block_main_down', '_addingBanner'); ?>
                    <span class="popup_modal_close">
                        <svg>
                            <use href="/resources/img/sprite.svg#x"></use>
                        </svg>
                    </span>
                </div>
                <div class="inputs-inline">
                    <label for="linkBlock"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_link'); ?></label>
                    <input id="linkBlock" name="url" type="text" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_linkPlaceholder'); ?>" required>
                </div>
                <div class="flex-inline">
                    <div class="inputs-inline">
                        <label for="titleBlock"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainText'); ?></label>
                        <input id="titleBlock" name="title" type="text" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainTextPlaceholder'); ?>" required>
                    </div>
                    <div class="inputs-inline">
                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_mainTextColor'); ?></label>
                        <input type="text" name="color_text" class="color_input" value="" data-jscolor="">
                    </div>
                </div>
                <div class="inputs-inline">
                    <label for="descriptionBlock"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_additionalText'); ?></label>
                    <input id="descriptionBlock" name="description" type="text" placeholder="<?= $Translate->get_translate_module_phrase('module_block_main_down', '_additionalTextPlaceholder'); ?>" required>
                </div>
                <hr>
                <div class="flex-inline">
                    <div class="inputs-inline">
                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_initialBgColor'); ?></label>
                        <input type="text" name="color_bg_start" class="color_input" value="" data-jscolor="">
                    </div>
                    <div class="inputs-inline">
                        <label><?= $Translate->get_translate_module_phrase('module_block_main_down', '_finalBgColor'); ?></label>
                        <input type="text" name="color_bg_end" class="color_input" value="" data-jscolor="">
                    </div>
                </div>
                <hr>
                <div class="inputs-inline">
                    <div class="file-upload-container">
                        <input type="file" id="file-input" class="custom-file-input" accept="image/*" name="file">
                        <label for="file-input"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_selectImage'); ?></label>
                        <div id="file-info" class="file-upload-info file-info" style="display: block"></div>
                    </div>
                </div>
                <hr>
                <div class="ppulse__aside-block" id="infoBlockPreview" style="flex: none;">
                    <a href="#" class="ppulse__aside-sort">
                        <span class="ppulse__aside-airtext" style="color: #fff" id="titlePreview"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_exampleTitle'); ?></span>
                        <img class="blockPreview" id="blockPreview" src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_down/assets/img/null-image.svg" alt="" loading="lazy">
                        <div class="ppulse__aside-button">
                            <span class="ppulse__aside-button-text" style="color: #fff" id="descriptionPreview"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_exampleDescription'); ?></span>
                        </div>
                    </a>
                </div>
                <hr>
                <button class="width-100" type="submit"><?= $Translate->get_translate_module_phrase('module_block_main_down', '_CreateBanner'); ?></button>
            </form>
        </div>
    </div>
<?php endif; ?>
</div>