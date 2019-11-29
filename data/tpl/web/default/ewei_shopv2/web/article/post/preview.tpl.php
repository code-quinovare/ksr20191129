<?php defined('IN_IA') or exit('Access Denied');?><div class="fart-preview">
        <div class="top"><p bind-to="art_title"><?php  if($aid) { ?><?php  echo $article['article_title'];?><?php  } else { ?>这里是文章标题<?php  } ?></p></div>
        <div class="main">
            <div class="fart-rich-primary">
                <div class="fart-rich-title" bind-to="art_title"><?php  if($aid) { ?><?php  echo $article['article_title'];?><?php  } else { ?>这里是文章标题<?php  } ?></div>
                <div class="fart-rich-mate">
                    <div class="fart-rich-mate-text" bind-to="art_date_v"><?php  if($aid) { ?><?php  echo $article['article_date_v'];?><?php  } else { ?><?php  echo date('Y-m-d');?><?php  } ?></div>
                    <div class="fart-rich-mate-text" bind-to="art_author"><?php  if($aid) { ?><?php  echo $article['article_author'];?><?php  } else { ?>编辑小美<?php  } ?></div>
                    <div class="fart-rich-mate-text href" bind-to="art_mp"><?php  if(empty($article['article_mp'])) { ?><?php  echo $mp['name'];?><?php  } else { ?><?php  echo $article['article_mp'];?><?php  } ?></div>
                </div>
                <div class="fart-rich-content" id="preview-content">
                    <?php  echo htmlspecialchars_decode($article['article_content'])?>
                </div>
                <div class="fart-rich-tool">
                    <div class="fart-rich-tool-text link">查看原文</div>
                    <div class="fart-rich-tool-text"><i class="icon icon-person2"></i></div>
                    <div class="fart-rich-tool-text" bind-to="art_read"> <?php  if($aid) { ?><?php  if($article['article_readnum_v']>100000) { ?>100000+<?php  } else { ?><?php  echo $article['article_readnum_v'];?><?php  } ?><?php  } else { ?>100000+<?php  } ?></div>
                    <div class="fart-rich-tool-text"><i class="icon icon-likefill text-danger"></i></div>
                    <div class="fart-rich-tool-text">
                        <span bind-to="art_like"> <?php  if($aid) { ?><?php  if($article['article_likenum_v']>100000) { ?>100000+<?php  } else { ?><?php  echo $article['article_likenum_v'];?><?php  } ?><?php  } else { ?>54321<?php  } ?></span>
                    </div>
                    <div class="fart-rich-tool-text right">反馈</div>
                </div>
            </div>
            <div class="fart-rich-sift product" <?php  if($article['product_advs_type']!=0) { ?>style="display:block;"<?php  } ?>>
                <div class="fart-rich-sift-line">
                    <div class="fart-rich-sift-border"></div>
                    <div class="fart-rich-sift-text"><a bind-to="product_adv_title"><?php  if($aid) { ?><?php  echo $article['product_advs_title'];?><?php  } else { ?>精品推荐<?php  } ?></a></div>
                </div>
                <div class="fart-rich-sift-img"><img src="../addons/ewei_shopv2/plugin/article/static/css/img01.jpg"></div>
                <div class="fart-rich-sift-more" bind-to="product_adv_more"><?php  if($aid) { ?><?php  echo $article['product_advs_more'];?><?php  } else { ?>更多精品<?php  } ?></div>
            </div>
        </div>
        <!-- 手机 -->
    </div>
<!--4000097827-->