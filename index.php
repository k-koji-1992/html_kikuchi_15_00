<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style1.css">
    <script src="js/BmapQuery1.js"></script>
    <title>すぐやる課アプリ</title>
</head>

<body>
    <div id="wrapper">
        <div>
            <header class="header">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="logo">
                            <img src="/img/logo_02.jpg" alt="">
                        </div>
                        <div class="navbar-header"><a class="navbar-brand" href="select.php">ブックマーク一覧</a></div>
                        <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                        <div class="navbar-header"><a class="navbar-brand" href="register.php">会員登録</a></div>
                    </div>
                </nav>
            </header>
        </div>

        <div>
            <!-- MAP[START] -->
            <div id="myMap" style="width: 100%; height: 700px;"></div>
            <!-- MAP[END] -->
        </div>

        <div id="thread"></div>
        <div id="response">
            <section id="contact">
                <div class="layout-contact">
                    <h2><span class="section-title">投稿</span></h2>

                    <form method="post" action="" class="wrapper">
                        <div class="form">
                            <fieldset>
                                <div class="form-list">
                                    <dl class="form-item">
                                        <dt class="form-label">投稿者：</dt>
                                        <dd class="form-detail"><input type="text" name="uname" id="uname" class="form-parts" placeholder="名前を書き込んでください">
                                        </dd>
                                    </dl>
                                    <dl class="form-item">
                                        <dt for="kana" class="form-label">投稿者の現在地：</dt>
                                        <dd class="form-detail"><input type="text" name="address1" id="address1" class="form-parts" placeholder="位置情報がここに表示されます" value="">
                                        </dd>
                                    </dl>
                                    <dl class="form-item">
                                        <dt class="form-label">依頼する住所：</dt>
                                        <dd class="form-detail"><input type="text" name="address2" id="address2" class="form-parts" placeholder="位置情報がここに表示されます" value=""></dd>
                                    </dl>

                                    <dl class="form-item form-item__textarea">
                                        <dt class="form-label form-label__textarea">依頼内容：</dt>
                                        <dd class="form-detail">
                                            <textarea name="comment" id="comment" value="" cols="30" rows="10" class="form-parts form-parts__textarea" placeholder="投稿を書き込んでください。
                                            例1:自宅の軒先に蜂の巣ができてしまったので駆除をお願いしたいです。
                                            例2:側溝に汚れがたまっているので清掃してください">
                                        </textarea>
                                        </dd>
                                    </dl>
                                </div>
                            </fieldset>
                        </div>
                        <button id="send" class="btn btn-submit">投稿</button>

                    </form>
                </div>
            </section>

        </div>

        <section id="contact">
            <div class="layout-contact">
                <h2><span class="section-title">会員登録</span></h2>

                <form action="" class="wrapper">
                    <div class="form">
                        <div class="form-list">
                            <dl class="form-item">
                                <dt for="name" class="form-label">名前</dt>
                                <dd class="form-detail"><input type="text" name="name" id="name" class="form-parts" placeholder="名前を書き込んでください">
                                </dd>
                            </dl>
                            <dl class="form-item">
                                <dt for="kana" class="form-label">カナ</dt>
                                <dd class="form-detail"><input type="text" name="kana" class="form-parts" placeholder="名前を書き込んでください"></dd>
                            </dl>
                            <dl class="form-item">
                                <dt for="email" class="form-label">メールアドレス</dt>
                                <dd class="form-detail"><input type="text" name="email" class="form-parts" placeholder="メールアドレスを書き込んでください"></dd>
                            </dl>

                </form>
            </div>
        </section>
        <footer class="footer text-center">
            <div class="wrapper">
                <small class="copyrights">copyrights G's Academy All RIghts Reserved.
                </small>
            </div>
        </footer>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApzkQEdYymyvakYqLcMkXK0DnXvvIW2Y66KKY-_I67uUAILst4XPqfQllOteMSCn' async defer></script>

    <script>
        // 1．位置情報の取得に成功した時の処理
        function mapsInit(position) {
            //lat=緯度、lon=経度 を取得
            console.log(position);
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            console.log(lat, lon);
        };
        //2． 位置情報の取得に失敗した場合の処理
        function mapsError(error) {
            let e = "";
            if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
                e = "位置情報が許可されてません";
            }
            if (error.code == 2) { //2＝現在地を特定できない
                e = "現在位置を特定できません";
            }
            if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
                e = "位置情報を取得する前にタイムアウトになりました";
            }
            alert("エラー：" + e);
        };

        //3.位置情報取得オプション
        var where = {
            enableHighAccuracy: true, //より高精度な位置を求める
            maximumAge: 20000, //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
            timeout: 10000 //10秒以内に現在地情報を取得できなければ、処理を終了
        };

        //Main:位置情報を取得する処理 //getCurrentPosition :or: watchPosition
        navigator.geolocation.getCurrentPosition(mapsInit, mapsError, where);

        //Initialization processing
        let map;

        function GetMap() {
            //1. Init
            map = new Bmap("#myMap");

            //2. geolocation: Display Map
            //------------------------------------------------------------------------
            map.geolocation(function(data) {
                //現在地の取得
                const lat = data.coords.latitude;
                const lon = data.coords.longitude;
                console.log(data)
                //現在地を中心にしたマップ
                map.startMap(lat, lon, "load", 15);
                //現在地のピン
                const currentLocationPin = map.pin(lat, lon, "#ff0000");

                const location = map.setLocation(lat, lon);
                map.reverseGeocode(location, function(data) {
                    console.log(data);
                    document.querySelector("#address1").value = data;
                });

                map.onGeocode("click", function(clickPoint) {
                    map.reverseGeocode(clickPoint.location, function(data) {
                        console.log(data);
                        document.querySelector("#address2").value = data;
                    });
                });

                //B. Get ReverseGeocode of click location
                map.onGeocode("click", function(data) {
                    console.log(data); //Get Geocode ObjectData
                    const lat = data.location.latitude; //Get latitude
                    const lon = data.location.longitude; //Get longitude
                    clickedLat = lat;
                    clickedLon = lon;
                    map.reverseGeocode(data)
                    console.log(data); //Get Geocode ObjectData

                    let pin = map.pin(lat, lon, "#0000ff")
                    // ピンを置く
                    map.onPin(pin, "click", function() {
                        map.reverseGeocode({
                            latitude: lat,
                            longitude: lon
                        }, function(address) {
                            // 逆ジオコーディングの結果（住所情報）を取得
                            let title = document.getElementById('uname').value;
                            let descript = '<div style="width:300px;">住所：</div>' + address; // 住所情報を使用

                            const options = [];
                            options[0] = map.onInfobox(lat, lon, title, descript)

                            map.infoboxLayers(options, true);
                        });
                    });
                });
            });



            // 投稿情報を地図上にピンとして表示
            posts.forEach(function(post) {
                var lat = parseFloat(post.latitude);
                var lon = parseFloat(post.longitude);

                var pin = map.pin(lat, lon, "#0000ff");

                map.onPin(pin, "click", function() {
                    var title = post.uname;
                    var descript = '<div style="width:300px;">住所：' + post.address2 + '</div><br>' + post.comment;
                    var options = [map.onInfobox(lat, lon, title, descript)];
                    map.infoboxLayers(options, true);
                });
            });
            // 地図読み込み時にデータベースからピンの情報を呼び出す。
            <?php
            include("funcs.php");
            $pdo = db_conn();

            $sql = "SELECT * FROM pins";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pins = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($pins as $pin) : ?>
                var lat = <?= $pin["latitude"] ?>;
                var lon = <?= $pin["longitude"] ?>;
                var address = "<?= $pin["address"] ?>";
                var content = "<?= $pin["content"] ?>";

                var pin = map.pin(lat, lon, "#0000ff");

                map.onPin(pin, "click", function() {
                    var title = "投稿内容";
                    var descript = '<div style="width:300px;">住所：' + address + '</div><br>' + content;
                    var options = [map.onInfobox(lat, lon, title, descript)];
                    map.infoboxLayers(options, true);
                });
            <?php endforeach; ?>
        }
    </script>


    <script type="module">
        $("#send").on("click", function() {
            const uname = $("#uname").val() || "匿名希望";
            const msg = {
                uname: uname,
                text: $("#text").val(),
                userId: getOrGenerateUserId(),
                address1: $("#address1").val(),
                address2: $("#address2").val(),
                latitude: clickedLat,
                longitude: clickedLon
            };

            $.post("insert.php", msg, function(response) {
                console.log(response);
            });
        });
    </script>

    <script async>
        const path = location.pathname;
        for (let opt of document.getElementById("orderSelect").options) {
            if (opt.value == path) {
                opt.selected = true;
                break;
            }
        }
    </script>

    <?php
    include("funcs.php");
    $pdo = db_conn();

    // 投稿情報を取得するSQL作成
    $sql = "SELECT * FROM `pins` ORDER BY indate DESC";
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    if ($status == false) {
        sql_error($stmt);
    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $row;
        }
    }
    ?>

</body>

</html>