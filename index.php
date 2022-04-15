<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>加密解密</title>
    <style>
        body {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        textarea {
            width: 100%;
        }

        #data {
            height: 150px;
        }

        #result {
            height: 280px;
        }
    </style>
</head>
<body>
<h3>加密解密</h3>
<textarea name="data" id="data" placeholder="待处理数据"></textarea>
<div class="btn">
    加密方式:
    <select name="method" id="method">
        <?php foreach (openssl_get_cipher_methods() as $item) : ?>
            <option value="<?= $item; ?>"><?= $item; ?></option>
        <?php endforeach; ?>
    </select>
    密钥:
    <input type="text" id="key" placeholder="密钥">
    <button id="encrypt">加密</button>
    <button id="decrypt">解密</button>
</div>
<textarea name="result" id="result" placeholder="处理后数据"></textarea>
<div class="copyright">
    &copy;
    <?php echo date('Y') ?>
    <a href="http://www.beian.miit.gov.cn/" target="_blank">渝ICP备20009256号</a>
    <br>
    该域名可转让 有意者请联系 info@liukaishui.com
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    $(function () {
        $('#encrypt,#decrypt').click(function () {
            $('#result').val('');
            var action = $(this).attr('id')
            $.ajax({
                type: 'POST',
                url: 'handle.php?action=' + action,
                dataType: 'json',
                data: {
                    data: $('#data').val(),
                    method: $('#method').val(),
                    key: $('#key').val()
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (action === 'encrypt') {
                            $('#result').val(JSON.stringify(res.data, null, 4));
                        } else {
                            $('#result').val(res.data);
                        }
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (res) {
                    alert('网络错误')
                }
            });
        });
    });
</script>
</body>
</html>
