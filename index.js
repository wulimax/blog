  //创造虚拟后台数据
    var arrs = ['品牌-林志敏','品牌-纪秀','北京-张鑫','产品-马冰','客服-王莹','北京-伊里奇','运营-乔晓义','北京-张晓辉','北京-盖立春','北京-刘岩','运营-张广武','运营-王思颖','北京-李国鹏','产品-张凯','客服-王蕾','北京-赵东','天津-宋来明','广州-李伯川','广州-梁湘','广州-秦境乔','广州-颜杰','广州-刘家敏','广州-黄嘉艺','广州-冷文钦','杭州-黄益斌','杭州-陈文娟','杭州-褚建生','杭州-周叶祥','杭州-孙新坚','罗达喜巴图','杭州-廖建军','深圳-宋春芳','深圳-刘小平','深圳-郑方敏','深圳-叶坤才','深圳-张飞','深圳-吴艳琴','深圳-王顺','深圳-黎剑平','成都-王思锜','成都-周禹佳','成都-杨文韬','成都-夏熊','成都-肖胜瑶','成都-舒微','成都-李磊','上海-马丁','上海-戴琪','上海-潘文德','上海-王根利','上海-朱楷','上海-杨超','天津-陈强','天津-孟宪玮','天津-王坤','天津-裴双春'];
    var comm_arr = ['微妙','财务-亢丽丽','人力-张圣楠','技术-尹月勇','产品-孔飞','技术-范钰心','技术-翟学伟','技术-王蒙','技术-李政武','技术-李昂','技术-徐根伟','北京-时光','技术-冯雅雅','财务-赵云凤','运营-沈翀','人事-董寅博','运营-王杨','运营-卫芳芳','技术-王文明','技术-李晓慧','财务-魏伟','财务-王静','广州-韩庆峰','杭州-徐文平','深圳-唐德','成都-孙自珍','天津-于国忠'];
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
    var  timeId = 0;
    btn.onclick = function () {
        if(this.value==="开始点名"){
                //定时
            timeId=setInterval(function () {
                //留下当前颜色
                var random = parseInt(Math.random()*arrs.length);
                       //清空所有颜色
                 for (var j = 0; j < arrs.length; j++) {
                    boxNode.children[j].style.background="";
                 }
                    boxNode.children[random].style.background="#E35F47";

            },100);
            this.value="停止";
        }else{
        	for (var j = 0; j < arrs.length; j++) {
                 if($('#box div').eq(j).css('background') == 'rgb(227, 95, 71) none repeat scroll 0% 0% / auto padding-box border-box'){
                 	if(comm_arr.indexOf($('#box div').eq(j).text()) > -1){
                        quchong();
                 	}else{
                 		if(get_user($('#box div').eq(j).text())){
                 			get_user($('#box div').eq(j).text(),true);
                      break;
                 		}else{
                 			quchong();
                 		}
                 		
                 	}
                 	
                 }
              }
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
     if(endtime == 0 || uarr == 0 || (timestamp-endtime) > 14400000 || username == ''){ return true ;}
     }
     uarr = JSON.parse(uarr)?JSON.parse(uarr):[];
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
  }
  function quchong(){
  	console.log('test')
  	for (var j = 0; j < arrs.length; j++) {
       $('#box div').eq(j).css({'background':''});          
      }
  	for (var j = 0; j < arrs.length; j++) {
  		if(get_user($('#box div').eq(j).text()) && comm_arr.indexOf($('#box div').eq(j).text()) == -1){
  			$('#box div').eq(j).css({'background':'#E35F47'}); 
            get_user($('#box div').eq(j).text(),true);
  			 break;
  		}
                
      }
  }
