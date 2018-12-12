+(function ($) {

    /*
        自定义的参数指令
        1. data - custom - url: 重写(data-url) url
        2. data-custom-windosurlparams:接收rul地址栏传来的参数，参数用逗号隔开
        3. data-hide-column：初始化隐藏列，列名以逗号隔开
    
    */

    // $.fn.bootstrapTable.init = function (tableid, params) {
    //     initGrid(tableid, params)
    // }

    var defaultsOptions = {
        formatLoadingMessage: function () {

            return '<div class="loader"></div>';
        }
    };


    //获取表格参数
    function getCustomattr(_this, tableId) {

        var defaultTable = {};
        defaultTable = {
            tableUrl: _this.attr("data-custom-url"),
            method: _this.attr("data-method") || "post",
            exportType: _this.attr("data-export-type") || "all",
            tableHidelist: _this.attr("data-hide-column"),
            autoHeight: $.utils.windowHeight() - tableId.offset().top - (Number(tableId.attr('data-autoheight'))),
            windosUrlparams: _this.attr("data-custom-windosurlparams"),
            contentType: _this.attr("data-content-type") || "application/x-www-form-urlencoded; charset=UTF-8"
        }

        return defaultTable;

    };

    //获取地址栏参数函数
    function gettableUrlparams(params) {

        var paramsMap = {};
        var tabeMap = params.split(',');

        for (var k in tabeMap) {
            paramsMap[tabeMap[k]] = $.utils.getUrlParams(tabeMap[k]);
        };

        return paramsMap;
    };

    //隐藏列函数
    function hideColumnFun(tableHidelist, tableId) {

        $(document).on("load-success.bs.table", tableId, function () {

            if (tableHidelist) {
                var hideColumnMap = tableHidelist;
                var arraycolumn = hideColumnMap.split(',');
                for (var i in arraycolumn) {
                    var key = $.trim(arraycolumn[i]);
                    tableId.bootstrapTable('hideColumn', key);
                };
            };
        });
    };

    //表格导出函数
    function tableExport(tableId, exportType) {

        function DoOnCellHtmlData(cell, row, col, data) {
            var result = "";
            if (typeof data != 'undefined' && data != "") {
                var html = $.parseHTML(data);

                $.each(html, function () {
                    if (typeof $(this).html() === 'undefined')
                        result += $(this).text();
                    else if (typeof $(this).attr('class') === 'undefined' || $(this).hasClass('th-inner') === true)
                        result += $(this).html();
                });
            }
            return result;
        };

        tableId.bootstrapTable('refreshOptions', {
            exportOptions: {
                ignoreColumn: [0, 1], // or as string array: ['0','checkbox']
                onCellHtmlData: DoOnCellHtmlData,
                exportDataType: exportType
            }
        });
    };

    //初始化函数
    function initGrid(_this, params) {

        var $this = _this;
        var tableId = $("#" + $this.attr("id"));

        var defaultMapparams = getCustomattr($this, tableId);

        var option = {
            url: defaultMapparams.tableUrl,
            method: defaultMapparams.method,
            contentType: defaultMapparams.contentType,
            height: defaultMapparams.autoHeight,
            queryParamsType: 'limit',
            pageSize: 50,
            queryParams: getParams,
            formatLoadingMessage: defaultsOptions.formatLoadingMessage
        };

        //获取地址栏参数
        var tableUrlparams = (defaultMapparams.windosUrlparams) ? gettableUrlparams(defaultMapparams.windosUrlparams) : {};

        //获取参数
        function getParams(params) {

            var temp = {
                order: params.order,
                limit: 50,
                offset: params.offset,
            };

            $.extend(temp, tableUrlparams); //合并参数

            return temp;
        };

        $.extend(tableId.bootstrapTable.defaults, option);

        $(window).resize(function () {
            tableId.bootstrapTable('resetView');
        });

        // 隐藏指定列处理
        hideColumnFun(defaultMapparams.tableHidelist, tableId);

        //导出初始化
        tableExport(tableId, defaultMapparams.exportType);

    };

    /*表格初始化*/
    $('[data-toggle="table"]').each(function () {
        var _this = $(this);
        initGrid(_this);
    });


    //事件监听
    $(document)
        .on('click.bootstrap.table.search', "[bootstrap-table-search]", function (e) { //表格搜索
            $this = $(this);

            var table_id = $this.attr("bootstrap-table-search");

            var searchForm = $("[bootstrap-table-form=" + table_id + "]");

            var searchParams = searchForm.serializeObject();

            var tableUrl = $("#" + table_id).attr("data-custom-url");

            var params = {
                url: $.cfg.server_api + tableUrl,
                query: searchParams
            };

            $("#" + table_id).bootstrapTable('refresh', params);

        })
        .on("click.bootstrap.table.reset", '[bootstrap-table-reset]', function (e) { //重置 

            $this = $(this);
            var reset_id = $this.attr("bootstrap-table-reset");
            var form_id = $("[bootstrap-table-form=" + reset_id + "]");
            form_id[0].reset();
        });

})(jQuery);