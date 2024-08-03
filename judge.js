const buttonClose = document.getElementById('modalClose');
const modal = document.getElementById('easyModal');
const title = document.getElementById("title");
const targetNum = document.getElementById("targetNum");
const yellowBent = document.getElementById("yellowBent");
const yellowLoss = document.getElementById("yellowLoss");
const redBent = document.getElementById("redBent");
const redLoss = document.getElementById("redLoss");
const paddleFlag = document.getElementById("paddleFlag");
const inputNum = document.getElementById('inputNum');


// ナンバーボタンをクリックしたとき
function number_click(number) {
    modal.style.display = 'block';
    title.innerHTML = "ゼッケンナンバー"+ number;
    targetNum.value = number;
    return;
};

function inputNumber_click(){
    modal.style.display = 'block';
    let number = inputNum.value;
    title.innerHTML = "ゼッケンナンバー" + number;
    targetNum.value = number;
};

// キャンセルをクリックした場合
function nofunc() {
    document.getElementById('easyModal').style.display = 'none';
};

// バツ印をクリックした場合
buttonClose.addEventListener('click', modalClose);
function modalClose(){
    modal.style.display = 'none';
};

// モーダルコンテンツ以外がクリックされた時
addEventListener('click', outsideClose);
function outsideClose(e){
    if(e.target == modal){
        modal.style.display = 'none';
    };
};

yellowBent.addEventListener('click',yBFlagAdd);
function yBFlagAdd(){
    paddleFlag.value = 1;
};

yellowLoss.addEventListener('click',yLFlagAdd);
function yLFlagAdd(){
    paddleFlag.value = 2;
};

redBent.addEventListener('click',rBFlagAdd);
function rBFlagAdd(){
    if(window.confirm("本当に赤のベントニーでよろしいですか?")){
        paddleFlag.value = 3;
    }else{
        paddleFlag.value = "";
    }
};

redLoss.addEventListener('click',rLFlagAdd);
function rLFlagAdd(){
    if(window.confirm("本当に赤のロスオブコンタクトでよろしいですか?")){
        paddleFlag.value = 4;
    }else{
        paddleFlag.value = "";
    }
};

    