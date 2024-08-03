// ナンバーボタンをクリックしたとき
function reportComplete_click(number) {
    let recordNumber = document.getElementsByClassName(number);
    for(var i=0;i<recordNumber.length;i++){
    recordNumber[i].style.backgroundColor = 'gray'; 
    }
};


