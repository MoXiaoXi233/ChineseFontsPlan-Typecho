<?php

/**
 * 中文网字计划插件，旨在加快自定义中文字体的加载体验
 *
 * @package 中文网字计划
 * @version 1.0.1
 * @author MoXiify
 * @link https://github.com/MoXiaoXi233/ChineseFontsPlan-Typecho
 */
class ChineseFontsPlan_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('ChineseFontsPlan_Plugin', 'run');
        return _t('插件已激活，请在设置中配置中文字体的CDN链接和样式。');
    }

    public static function deactivate()
    {
        return _t('插件已禁用。');
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $fontUrl = new Typecho_Widget_Helper_Form_Element_Text(
            'fontUrl',
            NULL,
            NULL,
            _t('中文字体 CDN 链接'),
            _t('请输入要导入的中文字体 CDN 链接<br>例：https://chinese-fonts-cdn.deno.dev/packages/lxgwwenkai/dist/LXGWWenKai-Light/result.css<br>
            字图 CDN 地址：<a href="https://chinese-font.netlify.app/zh-cn/cdn" target="_blank">点我跳转</a>，你也可以尝试：<a href="https://chinese-font.netlify.app/zh-cn/post/deploy_to_cdn" target="_blank">自行部署 CDN</a>')
        );
        $form->addInput($fontUrl);

        $fontFamily = new Typecho_Widget_Helper_Form_Element_Text(
            'fontFamily',
            NULL,
            'LXGW WenKai Light',
            _t('字体名称'),
            _t('请输入字体名称，例如：LXGW WenKai Light。')
        );
        $form->addInput($fontFamily);

        $fontWeight = new Typecho_Widget_Helper_Form_Element_Text(
            'fontWeight',
            NULL,
            '400',
            _t('字体粗细'),
            _t('请输入字体粗细，例如：400。')
        );
        $form->addInput($fontWeight);

        $targetClass = new Typecho_Widget_Helper_Form_Element_Text(
            'targetClass',
            NULL,
            '*',
            _t('目标类名'),
            _t('请输入要替换字体的目标类名，例如：body , article。如果要替换全局字体，请输入 *。')
        );
        $form->addInput($targetClass);
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
        // 个人用户的配置面板不需要额外配置
    }

    public static function run()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('ChineseFontsPlan');
        $fontUrl = $options->fontUrl;
        $fontFamily = $options->fontFamily;
        $fontWeight = $options->fontWeight;
        $targetClass = $options->targetClass;

        if (!empty($fontUrl)) {
            echo '<link rel="stylesheet preconnect" href="' . $fontUrl . '" type="text/css" media="print" onload="this.media=\'all\'" />' . "\n";
        }

        echo '<style type="text/css">';
        echo $targetClass . ' { font-family: \'' . $fontFamily . '\', sans-serif !important; font-weight: ' . $fontWeight . ' !important; }';
        echo '</style>' . "\n";
    }
}
