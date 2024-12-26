
    
    const header = document.querySelector("header")
    window.addEventListener("scroll",function(){
        x= window.pageYOffset
        if(x>0){
            header.classList.add("sticky")
    
        }
        else{
            header.classList.remove("sticky")
    
        }
    
    })
    const imgPosition = document.querySelectorAll(".aspect-ratio-169 img")
    const imgContainer = document.querySelector ('.aspect-ratio-169')
    const dotItem = document.querySelectorAll(".dot")
    let imgNumber = imgPosition.length
    let index =0
    imgPosition.forEach(function(img,index){
        img.style.left = index*100+"%"
        dotItem[index].addEventListener("click",function(){
            slider(index)
        })
    
    })
    function imgSlide(){
        index++;
        console.log(index)
        if(index>=imgNumber) {index=0}
        slider (index)
    
        
    }
    function slider(index){
        imgContainer.style.left = "-"+index*100+"%"
        const dotActive = document.querySelector('.active')
        dotActive.classList.remove("active")
        dotItem[index].classList.add("active")
    }
    setInterval(imgSlide,3000)
    const itemsliderbar = document.querySelectorAll(".cartegory-left-li")
    itemsliderbar.forEach(function(menu,index){
        menu.addEventListener("click",function(){
            menu.classList.toggle("block")
        })
    })
    



    // document.addEventListener("DOMContentLoaded", function () {
    //     // Lấy tất cả các nút toggle
    //     const toggleButtons = document.querySelectorAll(".toggle-btn");
    
    //     toggleButtons.forEach((btn) => {
    //         btn.addEventListener("click", function (e) {
    //             e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
    
    //             // Lấy dropdown (danh mục con) tương ứng
    //             const dropdown = this.nextElementSibling;
    
    //             if (dropdown) {
    //                 // Toggle class "active"
    //                 dropdown.classList.toggle("active");
    //                 dropdown.classList.toggle("hidden");
    //             }
    //         });
    //     });
    // });
    // document.querySelectorAll('.toggle-btn').forEach(btn => {
    //     btn.addEventListener('click', function () {
    //         // Tìm phần tử cha .cartegory-left-li
    //         const parentLi = this.closest('.cartegory-left-li');
            
    //         // Thêm hoặc xóa class "active" để hiển thị hoặc ẩn danh sách con
    //         parentLi.classList.toggle('active');
    //     });
    // });
    
// //-----------------------------Product---------------
// const baoquan = document.querySelector(".baoquan")
// const chitiet = document.querySelector(".chitiet")
// if(baoquan){
//     baoquan.addEventListener("click", function(){
//         document.querySelector(".product-content-right-buttom-content-chitiet").style.display = "none"
//         document.querySelector(".product-content-right-buttom-content-baoquan").style.display = "block"

//     })
//  }
// if(chitiet){
//     chitiet.addEventListener("click", function(){
//         document.querySelector(".product-content-right-buttom-content-chitiet").style.display = "block"
//         document.querySelector(".product-content-right-buttom-content-baoquan").style.display = "none"

//     })
// }
// const buttom = document.querySelector("product-content-right-buttom-top")
// if(buttom){
//     buttom.addEventListener("click",function(){
//         document.querySelector(".product-content-right-buttom-content-big").classList.toggle("activeB")

//     })
// }
// const bigImg = document.querySelector(".product-content-left-big-img img")
// const smallImg =document.querySelector(".product-content-left-small-img img")
// smallImg.forEach(function(imgItem,x){
//     imgItem.addEventListener("click",function(){
//         bigImg.src=imgItem.src
//     })
// })


