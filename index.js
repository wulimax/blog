
  //创造虚拟后台数据
    var arrs = ['国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊','国强','海云','丁会计','胜磊'];
    var comm_arr = ['test'];
      arrs = shuffle(arrs.concat(comm_arr));

    //获取父元素
    var boxNode = document.getElementById("box");
    for (var i = 0; i < arrs.length; i++) {
        //创建新元素
        var divNode = document.createElement("div");
        divNode.innerHTML=arrs[i];
        divNode.className="name";
        boxNode.appendChild(divNode);
    }
    //点名
    var btn= document.getElementById("btn");
    btn.onclick = function () {
        if(this.value==="开始点名"){
                //定时
            timeId=setInterval(function () {
                //留下当前颜色
                var random = parseInt(Math.random()*arrs.length);
                if(comm_arr.indexOf($('#box div').eq(random).text()) > -1){
                    console.log($('#box div').eq(random).text())
                 
                }else{
                       //清空所有颜色
                 for (var j = 0; j < arrs.length; j++) {
                    boxNode.children[j].style.background="";
                 }
                     if(get_user($('#box div').eq(random).text())){
                    boxNode.children[random].style.background="#E35F47";
                 }
                }

            },100);
            this.value="停止";
        }else{
            //清除计时器
            clearInterval(timeId);
            this.value="开始点名";
        }
    }
    // var spanNode = document.getElementById("span");
    //获取要排除的人员
   function get_user(username = '',type = false){
    var timestamp = new Date().getTime();
     var endtime = localStorage.getItem("timestamp")?localStorage.getItem("timestamp"):0;
     var uarr = localStorage.getItem("username")?localStorage.getItem("username"):0;
     if(!type){
     if(endtime == 0 || uarr == 0 || (timestamp-endtime) > 60000 || username == ''){ return true ;}
     }
     uarr = JSON.parse(uarr);
     if(type){
        uarr.push(username);
        uarr = JSON.stringify(uarr);
        localStorage.setItem("username",uarr);
        localStorage.setItem("timestamp",timestamp);
     }else{
      if(uarr.indexOf(username) > -1){ return false;}else{ return true;}

     }
   }
   function shuffle(array) {
    var tmp, current, top =array.length;
    if(top) while(--top){
    current =Math.floor(Math.random() * (top + 1));
    tmp =array[current];
    array[current] =array[top];
    array[top] = tmp;
    }
    return array;
