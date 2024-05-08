<template>
    <div>
        <div class="content">
            <div class="row d-flex justify-content-center">
                <div id="primary" class="col-12 col-md-10 col-lg-8">
                    <main id="main" class="site-main">
                        <article class="post-3216 page type-page status-publish ast-article-single" id="post-3216"
                            itemtype="https://schema.org/CreativeWork" itemscope="itemscope">
                            <header class="entry-header ast-no-title ast-header-without-markup">
                            </header> <!-- .entry-header -->
                            <div class="entry-content clear" ast-blocks-layout="true" itemprop="text">
                                <div data-elementor-type="wp-page" data-elementor-id="3216"
                                    class="elementor elementor-3216">
                                    <div class="elementor-element elementor-element-6fd13992 e-flex e-con-boxed e-con e-parent"
                                        data-id="6fd13992" data-element_type="container"
                                        data-settings="{&quot;content_width&quot;:&quot;boxed&quot;}"
                                        data-core-v316-plus="true">
                                        <div class="e-con-inner">
                                            <div class="elementor-element elementor-element-398e6bc5 elementor-widget elementor-widget-text-editor"
                                                data-id="398e6bc5" data-element_type="widget"
                                                data-widget_type="text-editor.default">
                                                <div class="elementor-widget-container mt-2" v-html="dataPrivacy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .entry-content .clear -->
                        </article><!-- #post-## -->
                    </main><!-- #main -->
                </div><!-- #primary -->
            </div> <!-- ast-container -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            dataPrivacy: [],
            apiBase : import.meta.env.VITE_AGENT_BASE_URL
        };
    },
    mounted(){
        this.getPrivacy();
    },
    methods:{
        getPrivacy: async function () {
            try {
                let config = {
                method: "get",
                url: this.apiBase + "/privacy",
                headers: {
                    "Content-Type": "application/json",
                },
                };

                await axios
                .request(config)
                .then((response) => {
                    this.dataPrivacy = response.data.privacy;
                })
                .catch((error) => {
                    console.log(error);
                });

            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>

<style></style>