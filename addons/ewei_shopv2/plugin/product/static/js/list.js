define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1};
    modal.init = function (params) {
       
        
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            modal.getList()
        }
    };

    modal.getList = function () {
        core.json('product/list/get_list', {page: modal.page}, function (ret) {
            var result = ret.result;
            $('#total').html(result.total);
            $('#money').html(result.money);
            if (result.total <= 0) {
                $('.content-empty').show();
                $('#container').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#container').show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_cashier_lineup_list', result, modal.page > 1)
        })
    };
    return modal;
});