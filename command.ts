
class Light {
    name:string;
    constructor(name:string){
        this.name = name;
    }
    on():void{
        console.log(this.name+"的燈開了")
    }
    off():void{
        console.log(this.name+"的燈關了")
    }
}
class Fan {
    speed:number;
    name:string;
    constructor(name:string){
        this.speed=0;
        this.name=name;
    }
    high():void{
        this.speed = 3
        console.log(this.name+"電扇開到最大")
    }
    medium():void{
        this.speed = 2
        console.log(this.name+"電扇開到中間")
    }
    low():void{
        this.speed = 1
        console.log(this.name+"電扇開最小")
    }
    off():void{
        this.speed = 0
        console.log(this.name+"電扇關閉")
    }
    getSpeed():number{
        return this.speed
    }
}

interface ICommand {
    execute():void
    undo():void
}

class FanHighCommand implements ICommand{
    fan:Fan;
    constructor(fan:Fan){
        this.fan = fan
    }
    execute(): void {
        this.fan.high();
    }
    undo(): void {
        const speed:number = this.fan.getSpeed() - 1;
        switch (speed) {
            case 2:
                this.fan.medium();
                break;
            case 1:
                this.fan.low();
            default:
                this.fan.off();
                break;
        }
    }
}
class FanMediumCommand implements ICommand{
    fan:Fan;
    prevSpeed: number;
    constructor(fan:Fan){
        this.fan = fan
        this.prevSpeed = fan.getSpeed();
    }
    execute(): void {
        this.fan.medium();
    }
    undo(): void { 
        switch (this.prevSpeed) {
            case 3:
                this.fan.high();
                break;
            case 2:
                this.fan.medium();
                break;
            case 1:
                this.fan.low();
            default:
                this.fan.off();
        }
    }
}
class FanLowCommand implements ICommand{
    fan:Fan;
    prevSpeed: number;
    constructor(fan:Fan){
        this.fan = fan
        this.prevSpeed = fan.getSpeed();
    }
    execute(): void {
        this.fan.low();
    }
    undo(): void { 
        switch (this.prevSpeed) {
            case 3:
                this.fan.high();
                break;
            case 2:
                this.fan.medium();
                break;
            case 1:
                this.fan.low();
            default:
                this.fan.off();
        }
    }
}
class FanOffCommand implements ICommand{
    fan:Fan;
    prevSpeed: number;
    constructor(fan:Fan){
        this.fan = fan
        this.prevSpeed = fan.getSpeed();
    }
    execute(): void {
        this.fan.off();
    }
    undo(): void { 
        switch (this.prevSpeed) {
            case 3:
                this.fan.high();
                break;
            case 2:
                this.fan.medium();
                break;
            case 1:
                this.fan.low();
            default:
                this.fan.off();
        }
    }
}
class LightOnCommand implements ICommand{
    light:Light;
    constructor(light:Light){
        this.light = light
    }
    execute(): void {
        this.light.on();
    }
    undo(): void {
        this.light.off();
    }
}
class LightOffCommand implements ICommand{
    light:Light;
    constructor(light:Light){
        this.light = light
    }
    execute(): void {
        this.light.off();
    }
    undo(): void {
        this.light.on();
    }
}
class noCommand implements ICommand{
    execute(): void {
        console.log("沒有命令")
    }
    undo(): void {
        console.log("沒有命令")
    }
}

class Controller {
    slot:ICommand= new noCommand;
    commandHistory:ICommand[] = [];
    setCommand(command:ICommand):void{
        this.slot= command;
    }
    runCommand():void{
        this.slot.execute();
        this.commandHistory.unshift(this.slot);
    }
    undoCommand(){
        if(this.commandHistory.length>0){
            this.commandHistory[0].undo();
            this.commandHistory.shift();
        }
    }
}

const livingRoomlight:Light = new Light('客廳');
const livingRoomlightOpen:LightOnCommand = new LightOnCommand(livingRoomlight);

const remoter = new Controller();
remoter.runCommand();

remoter.setCommand(livingRoomlightOpen);
remoter.runCommand();
remoter.runCommand();
remoter.undoCommand();

const fan:Fan = new Fan('客廳');

const fanOpen = new FanMediumCommand(fan);
remoter.setCommand(fanOpen);
remoter.runCommand();
remoter.undoCommand();

const fanLower = new FanLowCommand(fan);
remoter.setCommand(fanLower);
remoter.runCommand();
remoter.undoCommand();
remoter.undoCommand();