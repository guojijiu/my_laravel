<script>
    var websocket = new WebSocket("ws://127.0.0.1:1216");
    websocket.onopen = function (evt) {
        console.log("已连接websocket服务器");
        // 这里比较关键，通道建立后，可以进非常方便的进行轮询
        setInterval(function () {
            if (websocket.bufferedAmount == 0)
                var data = {"holding": "eyJLQNDqj0y473pCJ6zjMTUyOTk5NzU1MgnVMQ==$d84XkeMCv7umajhMRiU"};
            websocket.send(encodeMessage('test', data));
        }, 50);
    };
    // 监听消息体
    websocket.onmessage = function (evt) {
        console.log(decodeMessage(evt.data))
    };
    // 监听关闭消息
    websocket.onclose = function (evt) {
        console.log("websocket close");
    };
    //监听连接错误信息
    websocket.onerror = function (evt) {
        console.log(evt);
    };

    function decodeMessage(str) {
        return JSON.parse(str.substring(2))[1] || [];
    }

    function encodeMessage(event, data) {
        return JSON.stringify([
            event,
            data
        ])
    }
</script>
