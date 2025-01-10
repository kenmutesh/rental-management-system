import{p as d,o as l,f as i,a as x,w as h,F as m,b as t,t as o,i as g,q as c,d as k,s as D}from"./app-Cd6mMTGJ.js";import{_ as w}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */const _={data(){return{startDate:"",endDate:"",expenses:[],filteredExpenses:[],totalExpenses:0,totalCost:0}},methods:{filterExpenses(){this.filteredExpenses=this.expenses.filter(a=>{const e=new Date(a.date),u=this.startDate?new Date(this.startDate):new Date("1900-01-01"),p=this.endDate?new Date(this.endDate):new Date;return e>=u&&e<=p}),this.calculateTotals()},calculateTotals(){this.totalExpenses=this.filteredExpenses.reduce((a,e)=>a+e.amount,0),this.totalCost=this.filteredExpenses.reduce((a,e)=>a+e.amount*.8,0)},addExpense(){console.log("Adding a new expense...")},viewExpenseDetails(a){console.log(`Viewing details for expense ID: ${a}`)}},mounted(){this.expenses=[{id:1,expenseNumber:"EXP123",description:"Office Supplies",amount:150,date:"2024-03-10"},{id:2,expenseNumber:"EXP124",description:"Travel",amount:300,date:"2024-03-15"},{id:3,expenseNumber:"EXP125",description:"Software Subscription",amount:200,date:"2024-04-05"},{id:4,expenseNumber:"EXP126",description:"Marketing",amount:400,date:"2024-04-10"}],this.filterExpenses()},filters:{currency(a){return`$${a.toFixed(2)}`},formatDate(a){return new Date(a).toLocaleDateString()}}},E={class:"container mx-auto px-4 py-6"},v={class:"mb-6 grid grid-cols-1 md:grid-cols-2 gap-6"},C={class:"bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},N={class:"mt-2 text-lg font-medium text-green-600"},V={class:"bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},T={class:"mt-2 text-lg font-medium text-red-600"},P={class:"mb-6 flex space-x-4 items-center"},S={class:"mt-6 flex justify-end"},I={class:"overflow-x-auto shadow-lg rounded-lg mt-6"},A={class:"min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500"},F={class:"px-4 py-2"},X={class:"px-4 py-2"},B={class:"px-4 py-2"},M={class:"px-4 py-2"},H={class:"px-4 py-2"},L=["onClick"];function U(a,e,u,p,r,n){const b=d("Head"),f=d("PlusIcon"),y=d("app-layout");return l(),i(m,null,[x(b,{title:"Expenses"}),x(y,null,{default:h(()=>[t("div",E,[e[10]||(e[10]=t("div",{class:"mb-6 text-center"},[t("h1",{class:"text-3xl font-semibold text-gray-900 dark:text-gray-100"},"Manage Expenses"),t("p",{class:"text-gray-500 dark:text-gray-300"},"View and manage all your expenses.")],-1)),t("div",v,[t("div",C,[e[4]||(e[4]=t("h3",{class:"text-xl font-semibold text-gray-900 dark:text-gray-100"},"Total Expenses",-1)),t("p",N,o(r.totalExpenses),1)]),t("div",V,[e[5]||(e[5]=t("h3",{class:"text-xl font-semibold text-gray-900 dark:text-gray-100"},"Total Cost",-1)),t("p",T,o(r.totalCost),1)])]),t("div",P,[t("div",null,[e[6]||(e[6]=t("label",{for:"startDate",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"Start Date",-1)),g(t("input",{id:"startDate",type:"date","onUpdate:modelValue":e[0]||(e[0]=s=>r.startDate=s),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},null,512),[[c,r.startDate]])]),t("div",null,[e[7]||(e[7]=t("label",{for:"endDate",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"End Date",-1)),g(t("input",{id:"endDate",type:"date","onUpdate:modelValue":e[1]||(e[1]=s=>r.endDate=s),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},null,512),[[c,r.endDate]])]),t("button",{onClick:e[2]||(e[2]=(...s)=>n.filterExpenses&&n.filterExpenses(...s)),class:"flex items-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"}," Filter ")]),t("div",S,[t("button",{onClick:e[3]||(e[3]=(...s)=>n.addExpense&&n.addExpense(...s)),class:"flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"},[x(f,{class:"w-5 h-5 mr-2"}),e[8]||(e[8]=k(" Add Expense "))])]),t("div",I,[t("table",A,[e[9]||(e[9]=t("thead",null,[t("tr",null,[t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Expense #"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Description"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Amount"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Date"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Actions")])],-1)),t("tbody",null,[(l(!0),i(m,null,D(r.filteredExpenses,s=>(l(),i("tr",{key:s.id},[t("td",F,o(s.expenseNumber),1),t("td",X,o(s.description),1),t("td",B,o(s.amount),1),t("td",M,o(s.date),1),t("td",H,[t("button",{onClick:j=>n.viewExpenseDetails(s.id),class:"text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"}," View ",8,L)])]))),128))])])])])]),_:1})],64)}const G=w(_,[["render",U],["__scopeId","data-v-748d8942"]]);export{G as default};
