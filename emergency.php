<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/BmapQuery1.js"></script>
    <title>非常時救援MAP</title>
</head>

<body>
    <div id="wrapper">
        <div>
            <header class="header">
                <div class="logo">
                    <img src="/img/logo_03.jpg" alt="">

                </div>
                <nav>
                    <ul>
                        <li><a href="#about" class="about">このサイトについて</a></li>
                        <li><a href="#course" class="map">マップ</a></li>
                        <li><a href="#news" class="news">お知らせ</a></li>
                        <li><a href="#register" class="register">会員登録</a></li>
                        <li> <select id="orderSelect" name="select" onChange="location.href=value;">
                                <option disabled></option>
                                <option value="index.php">
                                    非常時
                                </option>
                                <option value="index1.php">
                                    平常時
                                </option>

                            </select></li>
                    </ul>
                </nav>
            </header>
        </div>


        <div>

            <h2>このＷｅｂアプリは非常時専用で運用しています。

            </h2>

        </div>
        <!-- <div id="geocode">ReverseGeocode:data</div> -->
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

                    <form action="" class="wrapper">
                        <div class="form">
                            <div class="form-list">
                                <dl class="form-item">
                                    <dt class="form-label">投稿者：</dt>
                                    <dd class="form-detail"><input type="text" id="uname" class="form-parts" placeholder="名前を書き込んでください">
                                    </dd>
                                </dl>
                                <dl class="form-item">
                                    <dt for="kana" class="form-label">投稿者の現在地：</dt>
                                    <dd class="form-detail"><input type="text" id="address1" class="form-parts" placeholder="位置情報がここに表示されます" value="">
                                    </dd>
                                </dl>
                                <dl class="form-item">
                                    <dt class="form-label">要救助者の現在地：</dt>
                                    <dd class="form-detail"><input type="text" id="address2" class="form-parts" placeholder="位置情報がここに表示されます" value=""></dd>
                                </dl>

                                <dl class="form-item form-item__textarea">
                                    <dt class="form-label form-label__textarea">状況：</dt>
                                    <dd class="form-detail">
                                        <textarea name="" id="text" value="" cols="30" rows="10" class="form-parts form-parts__textarea" placeholder="投稿を書き込んでください
                                            例1:家が倒壊しています。
                                            例2:家具に足を挟まれて動けません。
                                            
                                            "></textarea>

                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <button id="send" class="btn btn-submit">投稿</button>

                    </form>
                </div>
            </section>

        </div>


        </section>
        <footer class="footer text-center">
            <div class="wrapper">
                <small class="copyrights">copyrights G's Academy All RIghts Reserved.
                </small>
            </div>
        </footer>
        <!-- <div id="replyForm" style="display:none;">
            <textarea id="replyText" placeholder="返信を入力..."></textarea>
            <button id="sendReply">送信</button>
        </div> -->


    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApzkQEdYymyvakYqLcMkXK0DnXvvIW2Y66KKY-_I67uUAILst4XPqfQllOteMSCn' async defer></script>


    <!--** 以下Firebase **-->
    <script type="module">
        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries
        import {
            getDatabase,
            ref,
            push,
            set,
            update,
            onChildAdded,
            remove,
            onChildRemoved,
            onChildChanged
        }
        from "https://cdnjs.cloudflare.com/ajax/libs/firebase/10.7.1/firebase-database.js";
        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "[]",
            authDomain: "chat-trial-7029f.firebaseapp.com",
            projectId: "chat-trial-7029f",
            storageBucket: "chat-trial-7029f.appspot.com",
            messagingSenderId: "265048633140",
            appId: "1:265048633140:web:af568eeb81ba35149e3f61"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);

        // データベースの参照を作成
        // RealtimeDBに接続
        const db = getDatabase(app);
        // RealtimeDB内の"chat"を使う
        const dbRef = ref(db, "chat");
        const repliesRef = ref(db, "replies")

        $("#send").on("click", function() {
            const uname = $("#uname").val() || "匿名希望";
            const msg = {
                uname: uname,
                text: $("#text").val(),
                userId: getOrGenerateUserId(), // ユーザーIDを取得または生成
                address1: $("#address1").val(),
                address2: $("#address2").val(),
            };


            console.log(msg)
            const newPostRef = push(dbRef);

            // pushできる状態にする
            set(newPostRef, msg);

            // DBに値を送信


            $("#text").val('');
            // テキストボックス内のテキストをクリア
            $("#chatContainer").scrollTop($("#chatContainer")[0].scrollHeight);
            // スクロールを一番下に移動

        });
        // ランダムなID生成関数
        function generateRandomId() {
            return Math.random().toString(36).substring(2, 10);
        }

        // getOrGenerateUserId 関数の追加
        function getOrGenerateUserId() {
            let userId = localStorage.getItem("userId");
            if (!userId) {
                userId = generateRandomId();
                localStorage.setItem("userId", userId);
            }
            return userId;
        }

        let messageCount = 0; // 投稿されたメッセージの数を保持する変数
        onChildAdded(dbRef, function(data) {
            console.log(data)
            const msg = data.val();
            console.log(data.val)
            const key = data.key;
            // 削除・更新に必須
            var timestamp = new Date().toLocaleString();
            console.log(msg.address1)
            let h = '<p id="' + key + '">';
            h += ++messageCount + ": "; // メッセージ数に応じて番号を追加
            h += '<span contentEditable="true" id="' + key + '_update">' + msg.uname + '</span>';
            h += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // スペースを挿入
            h += timestamp;
            h += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // スペースを挿入
            h += "ユーザーID: " + msg.userId; // msgオブジェクトのuserIdを使用
            h += "<br>"
            h += '<span contentEditable="true" id="' + key + '_update">' + "現在地: " + msg.address1 + '</span>';
            h += "<br>"
            h += '<span contentEditable="true" id="' + key + '_update">' + "要救助者: " + msg.address2 + '</span>';
            h += "<br>"
            h += '<span contentEditable="true" id="' + key + '_update">' + msg.text + '</span>';
            h += "<br>"
            h += '<button class="remove" data-key="' + key + '">削除</button>';
            h += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // スペースを挿入
            h += '<button class="update" data-key="' + key + '">アップデート</button>';
            h += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // スペースを挿入
            h += '<button class="reply" data-key="' + key + '""}">返信</button>';
            h += "</p>";
            $("#thread").append(h); // #output の最後に追加
            memo.value = '';
        });

        // 削除イベント
        $("#thread").on("click", ".remove", function() {
            const key = $(this).attr("data-key")
            const remove_item = ref(db, "chat/" + key);
            remove(remove_item);
            // Firebaseデータ削除関数
        });

        // 更新イベント
        $("#thread").on("click", ".update", function() {
            const key = $(this).attr("data-key")
            update(ref(db, "chat/" + key), {
                text: $("#" + key + '_update').text(),

            });


        });
        onChildRemoved(dbRef, (data) => {
            $("#" + data.key).remove();
            // DOM操作関数
        });
        // 更新処理がFirebase側で実行されたらイベント発生
        onChildChanged(dbRef, (data) => {
            $("#" + data.key + '_update').fadeOut(800).fadeIn(800);

        });

        // const repliesRef = ref(db, 'replies/' + data.key);
        onChildAdded(repliesRef, function(replyData) {
            const replyMsg = replyData.val();

        });

        // 返信イベント
        $("#thread").on("click", ".reply", function() {
            const key = $(this).attr("data-key");
            const messageNumber = $('#' + key).text().split(":")[0]; // 投稿の番号を取得

            // 返信フォームを表示（リプライ先の番号を自動入力）
            const replyForm = '<div id="replyForm_' + key + '">' +
                '<textarea id="replyText_' + key + '">返信先: ' + messageNumber + '</textarea>' +
                '<button id="sendReply_' + key + '">返信送信</button>' +
                '</div>';
            $('#' + key).append(replyForm);

            // 返信送信イベント
            $('#sendReply_' + key).on('click', function() {
                const replyText = $('#replyText_' + key).val();
                // データベースに返信を保存
                const replyRef = ref(db, 'replies/' + key);
                push(replyRef, {
                    text: replyText,
                    repliedTo: key
                });

                // 返信内容をHTMLで表示
                const replyHTML = '<div class="reply-message">返信内容: ' + replyText + '</div>';
                $('#' + key).after(replyHTML); // 返信先の投稿の後に返信内容を追加
                // const replyRef = push(replyRef);

                // pushできる状態にする
                // set(newPostRef, msg);
                // 返信フォームを削除
                $('#replyForm_' + key).remove();
            });
        });
        // 返信に対する返信イベント
        $("#thread").on("click", ".reply-to-reply", function() {
            // 返信に対する返信のためのコードをここに記述
        });
    </script>

    <!-- Firebaseここまで -->

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
            const map = new Bmap("#myMap");

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
                    // document.querySelector("#geocode1").value = lat + ',' + lon;
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
                    // map.reverseGeocode(clickPoint.location,function(data){
                    map.reverseGeocode(data)
                    console.log(data); //Get Geocode ObjectData




                    // document.querySelector("#geocode2").value = lat + ',' + lon;
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

        }
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
</body>

</html>