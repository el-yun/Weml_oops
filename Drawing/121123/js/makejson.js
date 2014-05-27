/**
멤버변수 속성
*/
function memberVarPro(access, name, data)
{
	this.access = access;
	this.name = name;
	this.data = data;
}
/**
멤버변수를 생성
*/
function createMemberVar(value)
{
	this.variable = value;
}
/**
멤버함수를 생성
*/
function createMemberFunc(value)
{
	this.func = value;
}
/**
다이어그램을 생성
*/
function createDiagram(value)
{
	this.diagram = value;
}
/**
클래스를 생성
*/
function createClass(classname, value)
{
	classname = value;
}
/**
멤버함수 속성
*/
function memberFuncPro(access, name, return_, paramlist)
{
	this.access = access;
	this.name = name;
	this.returns = return_;
	this.paramlist = paramlist;
}
/**
멤버함수의 인자를 추가1
*/
function addParameter(data,name)
{
	this.paramdata = data;
	this.paramname = name;
}
/**
멤버함수의 인자를 추가2
*/
function addFinalParameter(data)
{
	this.param = data;
}