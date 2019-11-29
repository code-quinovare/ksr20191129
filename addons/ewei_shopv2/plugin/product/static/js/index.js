define(['core', 'tpl'],
function(core, tpl) {
    var modal = {};
    modal.init = function(params) {

        $('#btnSubmit').click(function() {
            if ($('#btnSubmit').attr('stop')) {
                return
            }
            if ($('#num').isEmpty()) {
                FoxUI.toast.show('请输入16位产品注册码');
                return
            }
            if (!$('#verifycode2').isInt() || $('#verifycode2').len() != 4) {
                FoxUI.toast.show('请输入验证码');
                return
            }
           
            
            $('#btnSubmit').html('验证中').attr('stop', 1);
            core.json('product/validate', {
                num: $('#num').val(),
                productname:$('#productname').val(),
                verifycode: $('#verifycode2').val()
            },
            function(ret) {
                if (ret.status != 1) {
                    FoxUI.toast.show(ret.result.message);
                    $('#btnSubmit').html('提交').removeAttr('stop');
                    return
                }
                FoxUI.alert('您已完成产品注册，并获赠五年延保和500积分！点击确认进入积分商城，兑换专用便携盒。', '',
                function() {
                    location.href = core.getUrl('creditshop')
                })
            },
            false, true)
        });
       $("#btnCode2").click(function() {
            $(this).prop('src', '../web/index.php?c=utility&a=code&r=' + Math.round(new Date().getTime()));
            return false
        })
    };
    return modal
});