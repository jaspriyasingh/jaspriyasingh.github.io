(function(){

function init(){
     var canvas = document.getElementsByTagName('canvas')[0];
     var c = canvas.getContext('2d');

     var container = {x:100,y:100,width:1000,height:700};
     var circles = [{x:400,y:400,r:90,color:313,vx:6,vy:10},
                    {x:500,y:300,r:100,color:225,vx:-2,vy:-8},
                    {x:300,y:350,r:55,color:55,vx:10,vy:-20},
                    {x:400,y:400,r:75,color:145,vx:3,vy:-8},
                    {x:500,y:200,r:40,color:5,vx:12,vy:-6}
     ];


     function draw(){
         c.fillStyle = 'black';
         c.strokeStyle = 'black';
         c.fillRect(container.x,container.y,container.width,container.height);
         
         for(var i=0; i <circles.length; i++){
             c.fillStyle = 'hsl(' + circles[i].color + ',100%,50%)';        //hsl is hue saturation lightness
             c.beginPath();
             c.arc(circles[i].x,circles[i].y,circles[i].r,0,2*Math.PI,false);
             c.fill();

             if((circles[i].x + circles[i].vx + circles[i].r > container.x + container.width) || (circles[i].x - circles[i].r + circles[i].vx < container.x)){
                circles[i].vx = - circles[i].vx;
             }
             if((circles[i].y + circles[i].vy + circles[i].r > container.y + container.height) || (circles[i].y - circles[i].r + circles[i].vy < container.y)){
                 circles[i].vy = - circles[i].vy;
             }
             circles[i].x +=circles[i].vx;
             circles[i].y +=circles[i].vy;
         }



         requestAnimationFrame(draw);

     }


    requestAnimationFrame(draw);


}

//invoke function init once document is fully loaded
window.addEventListener('load',init,false);

}());  //self invoking function