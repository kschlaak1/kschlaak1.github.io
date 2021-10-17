/* Framework for grid and setup observed from https://css-tricks.com/game-life/ */

//constructor for game of life object
function Game(canvas, config) {
    this.canvas = canvas;
    this.context = canvas.getContext("2d");
    this.matrix = undefined;
    this.generation = 0;

    var specs = {
        cellsX: 120,
        cellsY: 90,
        cellSize: 10,
        gridColor: "#ddd",
        cellColor: "#5f9ea0"
    };
    //merge specs and config
    this.config = $.extend({}, specs, config);

    //initialize canvas & matrix
    this.init();
}

//prototype of game
Game.prototype = {

    //initialize canvas
    init: function () {
        this.canvas.width = this.config.cellsX * this.config.cellSize;//120*10
        this.canvas.height = this.config.cellsY * this.config.cellSize;//90*10

        this.matrix = new Array(this.config.cellsX);
        for (var x = 0; x < this.matrix.length; x++) {
            this.matrix[x] = new Array(this.config.cellsY);
            for (var y = 0; y < this.matrix[x].length; y++) {
                this.matrix[x][y] = false;//all cells are initially dead
            }
        }
        this.draw();
    },

    //draw game on canvas
    draw: function () {
        var x, y;
        this.canvas.width = this.canvas.width;
        this.context.strokeStyle = this.config.gridColor;
        this.context.fillStyle = this.config.cellColor;

        for (x = 0.5; x < this.config.cellsX * this.config.cellSize; x += this.config.cellSize) {
            this.context.moveTo(x, 0);
            this.context.lineTo(x, this.config.cellsY * this.config.cellSize);
        }

        for (y = 0.5; y < this.config.cellsY * this.config.cellSize; y += this.config.cellSize) {
            this.context.moveTo(0, y);
            this.context.lineTo(this.config.cellsX * this.config.cellSize, y);
        }

        this.context.stroke();

        //draw matrix
        for (x = 0; x < this.matrix.length; x++) {
            for (y = 0; y < this.matrix[x].length; y++) {
                if (this.matrix[x][y]) {
                    this.context.fillRect(x * this.config.cellSize + 1,
                        y * this.config.cellSize + 1,
                        this.config.cellSize - 1,
                        this.config.cellSize - 1);
                }
            }
        }
    },

    //apply rules in buffer matrix
    inc: function () {
        //initialize buffer
        var x, y;
        var buffer = new Array(this.matrix.length);
        for (x = 0; x < buffer.length; x++) {
            buffer[x] = new Array(this.matrix[x].length);
        }

        //calculate one inc
        for (x = 0; x < this.matrix.length; x++) {
            for (y = 0; y < this.matrix[x].length; y++) {
                //count neighbors
                var neighbors = this.countNeighbors(x, y);

                //use rules
                if (this.matrix[x][y]) {
                    //live on assumed to be true unless other condtions are met
                    buffer[x][y] = true; 
                    if (neighbors < 2 || neighbors > 3) {
                        buffer[x][y] = false; //death from isolation/overpopulation
                    }
                } else {
                    if (neighbors == 3) { //reproduce
                        buffer[x][y] = true;
                    }
                }
            }
        }

        //flip buffers
        this.matrix = buffer;
        this.generation++;
        this.draw();
    },

    //counts living neighbors
    countNeighbors: function (cx, cy) {
        var count = 0;

        for (var x = cx - 1; x <= cx + 1; x++) {
            for (var y = cy - 1; y <= cy + 1; y++) {
                if (x == cx && y == cy) {
                    continue;
                }
                if (x < 0 || x >= this.matrix.length || y < 0 || y >= this.matrix[x].length) {
                    continue;
                }
                if (this.matrix[x][y]) {
                    count++;
                }
            }
        }
        return count;
    },

    //sets all cells to false to reset matrix
    reset: function () {
        for (var x = 0; x < this.matrix.length; x++) {
            for (var y = 0; y < this.matrix[x].length; y++) {
                this.matrix[x][y] = false;
            }
        }
        this.draw();
    },

    //creates random pattern in matrix where each cell has 30% chance to live
    randomize: function () {
        for (var x = 0; x < this.matrix.length; x++) {
            for (var y = 0; y < this.matrix[x].length; y++) {
                this.matrix[x][y] = Math.random() < 0.3;
            }
        }
        this.draw();
    },

    //toggle the state of a cell at the coordinates
    toggleCell: function (cx, cy) {
        if (cx >= 0 && cx < this.matrix.length && cy >= 0 && cy < this.matrix[0].length) {
            this.matrix[cx][cy] = !this.matrix[cx][cy];
            this.draw();
        }
    }
};

//initialize game
var game = new Game(document.getElementById("game"));//game canvas inherits all attributes and behaviors from the prototype
//animate loop
var timer;

//start
$("#start").click(
    function () {
        if (timer === undefined) {
            timer = setInterval(start, 100);//determines speed of game
        }
    }
);

//stop
$("#stop").click(
    function () {
        clearInterval(timer);
        timer = undefined;
    }
);

//inc
$("#inc").click(
    function () {
        if (timer === undefined) {//only increments if game is stopped
            game.inc();
            $("#generation span").text(game.generation);
        }
    }
);

//inc23
$("#inc23").click(
    function () {
        if (timer === undefined) {//only increments if game is stopped
            for (let i = 0; i < 23; i++) {
                game.inc();
                $("#generation span").text(game.generation);
            }
        }
    }
);

//reset
$("#reset").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
    }
)

//random
$("#rand").click(
    function () {
        game.randomize();
        game.generation = 0;
        $("#generation span").text(game.generation);
    }
);

//beehive
$("#beehive").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(50,40);
        game.toggleCell(51,40);
        game.toggleCell(49,41);
        game.toggleCell(52,41);
        game.toggleCell(50,42);
        game.toggleCell(51,42);
    }
);

//blinker
$("#blinker").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(50,40);
        game.toggleCell(51,40);
        game.toggleCell(52,40);
    }
);

//toad
$("#toad").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(50,40);
        game.toggleCell(51,40);
        game.toggleCell(52,40);
        game.toggleCell(51,41);
        game.toggleCell(52,41);
        game.toggleCell(53,41);
    }
);

//line
$("#line").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        var x;
        for(x = 0; x<game.matrix.length; x++) {
            game.toggleCell(x, 40);
        }
    }
);

//acorn
$("#acorn").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(47,40);
        game.toggleCell(48,40);
        game.toggleCell(48,42);
        game.toggleCell(50,41);
        game.toggleCell(51,40);
        game.toggleCell(52,40);
        game.toggleCell(53,40);
    }
)

//glider
$("#glider").click(
    function() {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(1,0);
        game.toggleCell(2,1);
        game.toggleCell(0,2);
        game.toggleCell(1,2);
        game.toggleCell(2,2);
    }
);

//spaceship
$("#spaceship").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(0,0);
        game.toggleCell(3,0);
        game.toggleCell(4,1);
        game.toggleCell(0,2);
        game.toggleCell(4,2);
        game.toggleCell(1,3);
        game.toggleCell(2,3);
        game.toggleCell(3,3);
        game.toggleCell(4,3);
    }
);

//Gosper's glider gun
$("#gun").click(
    function () {
        game.reset();
        game.generation = 0;
        $("#generation span").text(game.generation);
        game.toggleCell(0,5);
        game.toggleCell(1,5);
        game.toggleCell(0,6);
        game.toggleCell(1,6);

        game.toggleCell(10,6);
        game.toggleCell(11,5);
        game.toggleCell(11,6);
        game.toggleCell(11,7);
        game.toggleCell(12,4);
        game.toggleCell(12,5);
        game.toggleCell(12,6);
        game.toggleCell(12,7);
        game.toggleCell(12,8);
        game.toggleCell(13,3);
        game.toggleCell(13,4);
        game.toggleCell(13,8);
        game.toggleCell(13,9);
        game.toggleCell(14,4);
        game.toggleCell(14,5);
        game.toggleCell(14,6);
        game.toggleCell(14,7);
        game.toggleCell(14,8);
        game.toggleCell(15,4);
        game.toggleCell(15,8);
        game.toggleCell(16,5);
        game.toggleCell(16,7);
        game.toggleCell(17,6);

        game.toggleCell(20,4);
        game.toggleCell(21,2);
        game.toggleCell(21,3);
        game.toggleCell(21,5);
        game.toggleCell(21,6);
        game.toggleCell(23,1);
        game.toggleCell(23,7);
        game.toggleCell(25,1);
        game.toggleCell(25,2);
        game.toggleCell(25,4);
        game.toggleCell(25,6);
        game.toggleCell(25,7);

        game.toggleCell(34,3);
        game.toggleCell(35,3);
        game.toggleCell(34,4);
        game.toggleCell(35,4);
    }
)

//mousedown on canvas
game.canvas.addEventListener("mousedown", function(e) {
    gameOnClick(game.canvas, e)
})

//gets coordinates of cell to toggle
function gameOnClick(canvas, event) {
    var x;
    var y;
    const rect = canvas.getBoundingClientRect()
    x = event.clientX - rect.left;
    y = event.clientY - rect.top;
    x = Math.floor(x/game.config.cellSize);
    y = Math.floor(y/game.config.cellSize);
    game.toggleCell(x, y);
}

//starts loop
function start() {
    game.inc();
    $("#generation span").text(game.generation);
}
