<?php
/**
 * @var string $methodHtml Method contents
 */

echo $methodHtml;

?>

<script>
    (function (window) {
        'use strict';

        /**
         * @param {Element} node
         */
        var handleTabClick = function (node) {
            var
                ul = node.parentNode.parentNode,
                i;

            for (i in ul.childNodes) {
                var li = ul.childNodes[i];
                if (li.nodeType === Node.ELEMENT_NODE) {
                    li.classList.remove('active');
                }
            }
            // Add class to current li element
            node.parentNode.classList.add('active');

            // Show needed tab
            var tabsContents = ul.parentNode.querySelectorAll('.tab');
            //debugger;
            for (i = 0; i < tabsContents.length; i++) {
                var tab = tabsContents.item(i);
                tab.classList.add('hidden');

                if (tab.classList.contains(node.dataset.target)) {
                    tab.classList.remove('hidden')
                }
            }
        };


        window.apiBuilderTabClick = window.apiBuilderTabClick || handleTabClick;
    })(window);
</script>

<style>
    .api-builder .api-method {
        border-radius: 5px;
        border: 1px solid #E6E6E6;
        padding: 10px;
        margin-bottom: 20px;
        background: #F5F8FB;
    }

    .api-builder .api-method h1 {
        margin: 0 0 10px;
        padding: 0;
        font-weight: 600;
        font-size: 15px;
    }

    .api-builder .api-method .call-url {
        margin: 0 -10px 10px;
        padding: 10px 10px;
        background: white;
        border-top: 1px solid #E6E6E6;
        border-bottom: 1px solid #E6E6E6;
    }

    /*noinspection ALL*/
    .api-builder .api-method .call-url .method {
        font-weight: bold;
        font-family: courier, monospace;
        margin-right: 10px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .api-builder .api-method .call-url .method.method-post {
        color: #ff0002;
    }

    .api-builder .api-method .call-url .method.method-get {
        color: #0050d7;
    }

    .api-builder .api-method .call-url .domain {
        font-family: monospace;
        color: gray;
    }

    .api-builder .api-method .call-url .uri {
        font-family: monospace;
        font-weight: 800;
    }

    .api-builder .api-method .nav-tabs {
        margin: 0 -10px 10px;
        padding: 0 10px;
        border-bottom: 1px solid #E6E6E6;
    }

    .api-builder .api-method .tab {
        background: white;
        margin: -11px;
        padding: 15px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #E6E6E6;

    }

    .api-builder .api-method .param-block {
        border: 1px solid #E6E6E6;
    }

    .api-builder .api-method .param-block .param-block {
        border-bottom: none;
        border-right: none;
        border-top: none;
        margin-left: 25px;
        margin-top: 0;
    }

    .api-builder .api-method .param-block .sub {
        border-top: 1px solid #E6E6E6;
        border-left: 20px solid #E6E6E6;
    }

    .api-builder .api-method .param-block .item .cols {
        display: table;
        table-layout: fixed;
        width: 100%;
        border-top: 1px solid #E6E6E6;
    }

    .api-builder .api-method .param-block .item:first-child .cols {
        border-top: none;
    }

    .api-builder .api-method .param-block .cols > div {
        display: table-cell;
        padding: 5px 10px;
        border-left: 1px solid #E6E6E6;
    }

    .api-builder .api-method .param-block .cols > div:first-child {
        border-left: none;
    }

    .api-builder .api-method .param-block .name {
        min-width: 140px;
        font-family: monospace;
        font-weight: 600;
    }

    .api-builder .api-method .param-block .format {
        min-width: 140px;
        font-size: 12px;
    }

    .api-builder .api-method code {
        background: white;
        border: 1px solid #E6E6E6;
    }

    .api-builder .api-method code a:link {
        text-decoration: underline;
    }

    .api-builder .api-method .required {
        color: red;
        font-family: "courier new", serif;
        font-weight: bold;
        margin-left: 5px;
    }
</style>