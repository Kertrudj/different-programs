var lauasuurus;
var laevadearv;
var algusaeg;
var uustabel = false;
var board1Laevad = 0;
var board2Laevad = 0;
var myBombing = 0;
var opponentBombing = 0;
var minuEdukas = 0;
var opponentEdukas = 0;
var ok;
var loppaeg;
var manguaeg;
var mangudearv = 0;

//võtab id järgi sisestatud väärtuse
function takeId(x) {
    return document.getElementById(x);
}

//suvalise täisarvu funktsioon mingis vahemikus
function random(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function laevakoht(a, x, y) {
    var i;
    for (i = 0; i < 2; i++) {
        y += i;
        //kas ruut on vaba
        if (takeId(a + x + y).className != "water") {
            return ok = false;
        }
        //alumine ruut
        if (x + 2 <= lauasuurus) {
            if (takeId(a + (x + 1) + y).className != "water") {
                return ok = false;
            }
        }
        //ülemine ruut
        if (x - 1 >= 0) {
            if (takeId(a + (x - 1) + y).className != "water") {
                return ok = false;
            }
        }
        //vasak ruut
        if (y - 1 >= 0) {
            if (takeId(a + x + (y - 1)).className != "water") {
                return ok = false;
            }
        }
        //parem ruut
        if (y + 2 <= lauasuurus) {
            if (takeId(a + x + (y + 1)).className != "water") {
                return ok = false;
            }
        }
    }
    return ok = true;
}

//mänguvälja tegemine
$('#boardselect').change(
    function(){
        lauasuurus = parseInt($(this).find('option:selected').val());
        
        //mängija laud
        var s = "";
        var a = "a";
        s += "<table>"
        for (i = 0; i < lauasuurus; i++) {
            s += "<tr>"
            for (j = 0; j < lauasuurus; j++) {
                //annab tabeli ruudule id ja klassi
                s += '<td id=' + a + "" + i + "" + j + ' class="water" >'; 
                s += "</td>";
            }
            s += "</tr>";

        }
        s += "</table>";
        
        //arvuti laud
        var s1 = "";
        var b = "b";
        s1 += "<table>";
        for (i=0; i<lauasuurus; i++){
            s1 += "<tr>";
            s1 += [];
            for(j=0; j<lauasuurus; j++){
                s1 += '<td id=' + b + "" + i + "" + j + ' class="water" onclick = pommita(this) >';
                s1 += "</td>";
            }
            s1 += "</tr>";
        }
        s1 += "</table>";
        uustabel = true;
        
        document.getElementById('board1').innerHTML = s; //tee mängija laud
        document.getElementById('board2').innerHTML = s1; // vastase laud
        $('#tulemus').empty();
    }
)

//laevade tegemine
$('#shipselect').change(
    function(){
        laevadearv = parseInt($(this).find('option:selected').val());
        if(laevadearv < lauasuurus){
            algusaeg = new Date().getTime();

            board1Laevad = 0;
            for (i=0; i<laevadearv; i++){
                //oma laevade panemine
                for (j=0; j<laevadearv*2; j++){
                    var b1col = random(0, lauasuurus - 2);
                    var b1row = random(0, lauasuurus - 1);
                    var tulem = laevakoht('a', b1row, b1col);
                    if (tulem == true){ //kui ok on true, siis tulem true
                        break //tuleb eelmisest for-loopist välja
                    }
                }
                if(tulem == true){
                    var b1col2 = b1col + 1;
                    board1Laevad++;
                    takeId('a' + b1row + b1col).className = "laev";
                    takeId('a' + b1row + b1col).style.backgroundImage = 'url("http://img.brothersoft.com/icon/softimage/b/battleship_chess-56352.jpeg")';
                    takeId('a' + b1row + b1col2).className = "laev";
                    takeId('a' + b1row + b1col2).style.backgroundImage = 'url("http://img.brothersoft.com/icon/softimage/b/battleship_chess-56352.jpeg")';
                }
            }

            //vastase laevade panemine
            board2Laevad = 0;
            for (i=0; i<laevadearv; i++){
                for(j=0; j<laevadearv*2; j++){
                    var b2col = random(0, lauasuurus - 2);
                    var b2row = random(0, lauasuurus - 1);
                    var tulem = laevakoht('b', b2row, b2col);
                    if (tulem == true){
                        break
                    }
                }
                if(tulem == true){
                    var b2col2 = b2col + 1;
                    board2Laevad++;
                    takeId('b' + b2row + b2col).className = "laev";
                    takeId('b' + b2row + b2col2).className = "laev";
                }
            }
        }else if(laevadearv >= lauasuurus){
            alert('Vali õige laevade arv');
            document.getElementById('shipselect').value = "";
        }
    }
)

//vastase pommitamine
function pommita(x){
    
    //kui möödas
    if (x.className == "water"){
        document.getElementById(x.id).style.backgroundImage = 'url("https://a8b9696a91de10cc2c20196ef7b687396774edd5.googledrive.com/host/0B0RTlVpNFM-GfkRsWVdJOXJaZkJIQXV5OXRhcDZEVFBfb0ZMak9TOWJhNnFEZ1ZYZ0Y0blU/dark-blue-wallpaper-image-OBuq.jpg")';
        myBombing++;
        arvutiPommita();
    }
    
    //kui pihtas
    if (x.className == "laev"){
        document.getElementById(x.id).style.backgroundImage = 'url("http://wallofgame.info/images/battleship_2.png")';
        minuEdukas++;
        myBombing++;
        voitjaselgitamine();
    }
}

function arvutiPommita() {
    var x = random(0, lauasuurus - 1);
    var y = random(0, lauasuurus - 1);
    
    //Kui on juba kord sinna pommitanud, pommita uuesti kuskile
    if (takeId('a' + x + y).style.color == 'black') {
        opponentBombing = opponentBombing;
        arvutiPommita();
    }
   
    //arvuti lasi mööda
    if (takeId('a' + x + y).className == "water") {
        takeId('a' + x + y).style.backgroundImage = 'url("https://a8b9696a91de10cc2c20196ef7b687396774edd5.googledrive.com/host/0B0RTlVpNFM-GfkRsWVdJOXJaZkJIQXV5OXRhcDZEVFBfb0ZMak9TOWJhNnFEZ1ZYZ0Y0blU/dark-blue-wallpaper-image-OBuq.jpg")';
        takeId('a' + x + y).style.color = 'black';
        opponentBombing++;
        console.log('Arvuti tulistamised: ' + opponentBombing);
        
    }
    //arvuti sai pihta
    if (takeId('a' + x + y).className == "laev") {
        takeId('a' + x + y).style.backgroundImage = 'url("http://wallofgame.info/images/battleship_2.png")';
        takeId('a' + x + y).style.color = 'black';
        
        opponentBombing++;
        opponentEdukas++;
        console.log('Arvutitulistamised: ' + opponentBombing);
        arvutiPommita();

    }
}

//võitja selgitamine
function voitjaselgitamine(){
    if(minuEdukas == laevadearv * 2){ //mängija võit
        loppaeg = new Date().getTime();
        manguaeg = Math.abs(algusaeg - loppaeg);
        mangudearv++;
        
        document.getElementById('tulemus').innerHTML = "Sinu võit!" + "<br>" + "Arvuti tulistas: " + opponentBombing + " korda<br>" + "Sina tulistasid: " + myBombing + " korda<br>";
        
        tulemusetabel();
        
        //algväärtusta väljad
        $('#board1').empty();
        $('#board2').empty();
        myBombing = 0;
        opponentBombing = 0;
        minuEdukas = 0;
        opponentEdukas = 0;
    } else if(opponentEdukas == laevadearv * 2){ //arvuti võit
        loppaeg = new Date().getTime();
        manguaeg = Math.abs(algusaeg - loppaeg);
        mangudearv++;
        
        document.getElementById('tulemus').innerHTML = "Arvuti võit!" + "<br>" + "Arvuti tulistas: " + opponentBombing + " korda<br>" + "Sina tulistasid: " + myBombing + " korda<br>";
        
        tulemusetabel();
        
        //algväärtusta väljad
        $('#board1').empty();
        $('#board2').empty();
        myBombing = 0;
        opponentBombing = 0;
        minuEdukas = 0;
        opponentEdukas = 0;
    }
}

function tulemusetabel(){
    var mangutulemus = '<tr><td>' + mangudearv + '</td><td>' + lauasuurus + 'x' + lauasuurus + '</td><td>' + laevadearv + '</td><td>' + myBombing + '</td><td>' + opponentBombing + '</td><td>' + parseInt(manguaeg)/1000 + '</td></tr>';
    
    if(mangudearv <= 10){
        $('#tulemustabeliSisu').append(mangutulemus);
    } else{
        $('#tulemustabeliSisu').empty();
    }
}

//nupu vajutamine
$('#nupp').click(function(){
    if(uustabel){
        document.getElementById("boardselect").value = "";
        document.getElementById("shipselect").value = "";
        $('#tulemus').empty();
        $('#board1').empty();
        $('#board2').empty();
        myBombing = 0;
        opponentBombing = 0;
        minuEdukas = 0;
        opponentEdukas = 0;
    }
})