/**
*
*	멤버변수 속성을 json형식으로 만드는 함수
*
*	@param	access	접근제한자
*	@param	name	이름
*	@param	data	자료형
*	@return 없음
*/
function memberVarPro(access, name, data)
{
	this.access = access;
	this.name = name;
	this.data = data;
}
/**
*
*	멤버변수를 생성하는 함수
*
*	@param	value	멤버변수List
*	@return 없음
*/
function createMemberVar(value)
{
	this.variable = value;
}
/**
*
*	멤버함수를 생성하는 함수
*
*	@param	value	멤버함수List
*	@return 없음
*/
function createMemberFunc(value)
{
	this.func = value;
}
/**
*
*	다이어그램을 생성하는 함수
*
*	@param	value	클래스List
*	@return 없음
*/
function createDiagram(value)
{
	this.diagram = value;
}
/**
*
*	클래스를 생성하는 함수
*
*	@param	vardata		멤버변수 값
*	@param	funcdata	멤버함수 값
*	@param	currentClass	현재 활성화 되어있는 클래스의 이름
*	@param	relation	클래스간 연관관계 정보
*	@param	nodeid 클래스 고유 값
*	@return 없음
*/
function createClass(vardata, funcdata, currentClass, relation, nodeid)
{
	this.classname = currentClass;
	this.classid = nodeid;
	this.variableData = vardata;
	this.functionData = funcdata;
	this.relationship = relation;
}
/**
*
*	멤버함수 속성을 json형식으로 만드는 함수
*
*	@param	access	접근제한자
*	@param	name	이름
*	@param	return_	반환형
*	@param	paramlist	파라미터 정보
*	@return 없음
*/
function memberFuncPro(access, name, return_, paramlist)
{
	this.access = access;
	this.name = name;
	this.returns = return_;
	this.param = paramlist;
}
/**
멤버함수의 인자를 추가1

function addParameter(data,name)
{
	this.paramdata = data;
	this.paramname = name;
}
/**
멤버함수의 인자를 추가2

function addFinalParameter(data)
{
	this.param = data;
}
*/

/**
*
*	클래스 이름을 추가하는 함수
*
*	@param	name	클래스 이름
*	@return 없음
*/
function addClassName(name)
{
	this.classlist = name;
}

/**
*
*	연관관계를 추가하는 함수
*
*	@param	relation_name	연관관계종류
*	@param	class_name		관계맻는 클래스 이름
*	@return 없음
*/
function addRelation(relation_name, class_name)
{
	this.relation = relation_name;
	this.classname = class_name;
	/*
	this.dependent = dependent;
	this.inheritance = inheritance;
	this.aggregation = aggregation;
	this.association = association;
	this.composition = composition;
	*/
}

/**
*
*	연관 부모-자식 관계 추가하는 함수
*
*	@param	parent	부모 클래스
*	@param	children	자식 클래스
*	@return 없음
*/
function addParentnChild(parent, children)
{
	this.parent = parent;
	this.children = children;
}

/**
*
*	클래스 접두사 추가하는 함수
*
*	@param	classData	클래스 정보
*	@return 없음
*/
function addPrefixClass(classData)
{
	this.class_ = classData;
}

