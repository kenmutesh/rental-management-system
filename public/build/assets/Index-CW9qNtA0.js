import{p as d,o as l,f as i,a as x,w as k,F as m,b as t,t as o,i as g,q as c,d as D,s as w}from"./app-Cd6mMTGJ.js";import{_}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */const E={data(){return{startDate:"",endDate:"",expenses:[],filteredExpenses:[],totalExpenses:0,totalCost:0}},methods:{filterExpenses(){this.filteredExpenses=this.expenses.filter(a=>{const e=new Date(a.date),p=this.startDate?new Date(this.startDate):new Date("1900-01-01"),u=this.endDate?new Date(this.endDate):new Date;return e>=p&&e<=u}),this.calculateTotals()},calculateTotals(){this.totalExpenses=this.filteredExpenses.reduce((a,e)=>a+e.amount,0),this.totalCost=this.filteredExpenses.reduce((a,e)=>a+e.amount*.8,0)},addExpense(){console.log("Adding a new expense...")},viewExpenseDetails(a){console.log(`Viewing details for expense ID: ${a}`)}},mounted(){this.expenses=[{id:1,expenseNumber:"EXP123",description:"Office Supplies",amount:150,date:"2024-03-10"},{id:2,expenseNumber:"EXP124",description:"Travel",amount:300,date:"2024-03-15"},{id:3,expenseNumber:"EXP125",description:"Software Subscription",amount:200,date:"2024-04-05"},{id:4,expenseNumber:"EXP126",description:"Marketing",amount:400,date:"2024-04-10"}],this.filterExpenses()},filters:{currency(a){return`$${a.toFixed(2)}`},formatDate(a){return new Date(a).toLocaleDateString()}}},v={class:"container mx-auto px-4 py-6"},C={class:"mb-6 grid grid-cols-1 md:grid-cols-2 gap-6"},N={class:"bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},V={class:"mt-2 text-lg font-medium text-green-600"},T={class:"bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},P={class:"mt-2 text-lg font-medium text-red-600"},S={class:"mb-6 flex space-x-4 items-center"},I={class:"mt-6 flex justify-end"},A={class:"overflow-x-auto shadow-lg rounded-lg mt-6"},F={class:"min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500"},X={class:"px-4 py-2"},B={class:"px-4 py-2"},M={class:"px-4 py-2"},H={class:"px-4 py-2"},L={class:"px-4 py-2"},U={class:"px-4 py-2"},j=["onClick"];function q(a,e,p,u,r,n){const b=d("Head"),f=d("PlusIcon"),y=d("app-layout");return l(),i(m,null,[x(b,{title:"Expenses"}),x(y,null,{default:k(()=>[t("div",v,[e[10]||(e[10]=t("div",{class:"mb-6 text-center"},[t("h1",{class:"text-3xl font-semibold text-gray-900 dark:text-gray-100"},"Manage Expenses"),t("p",{class:"text-gray-500 dark:text-gray-300"},"View and manage all your expenses.")],-1)),t("div",C,[t("div",N,[e[4]||(e[4]=t("h3",{class:"text-xl font-semibold text-gray-900 dark:text-gray-100"},"Total Expenses",-1)),t("p",V,o(r.totalExpenses),1)]),t("div",T,[e[5]||(e[5]=t("h3",{class:"text-xl font-semibold text-gray-900 dark:text-gray-100"},"Total Cost",-1)),t("p",P,o(r.totalCost),1)])]),t("div",S,[t("div",null,[e[6]||(e[6]=t("label",{for:"startDate",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"Start Date",-1)),g(t("input",{id:"startDate",type:"date","onUpdate:modelValue":e[0]||(e[0]=s=>r.startDate=s),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},null,512),[[c,r.startDate]])]),t("div",null,[e[7]||(e[7]=t("label",{for:"endDate",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"End Date",-1)),g(t("input",{id:"endDate",type:"date","onUpdate:modelValue":e[1]||(e[1]=s=>r.endDate=s),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},null,512),[[c,r.endDate]])]),t("button",{onClick:e[2]||(e[2]=(...s)=>n.filterExpenses&&n.filterExpenses(...s)),class:"flex items-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"}," Filter ")]),t("div",I,[t("button",{onClick:e[3]||(e[3]=(...s)=>n.addExpense&&n.addExpense(...s)),class:"flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"},[x(f,{class:"w-5 h-5 mr-2"}),e[8]||(e[8]=D(" Add Expense "))])]),t("div",A,[t("table",F,[e[9]||(e[9]=t("thead",null,[t("tr",null,[t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"#"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Expense #"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Description"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Amount"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Date"),t("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Actions")])],-1)),t("tbody",null,[(l(!0),i(m,null,w(r.filteredExpenses,(s,h)=>(l(),i("tr",{key:s.id},[t("td",X,o(h+1),1),t("td",B,o(s.expenseNumber),1),t("td",M,o(s.description),1),t("td",H,o(s.amount),1),t("td",L,o(s.date),1),t("td",U,[t("button",{onClick:O=>n.viewExpenseDetails(s.id),class:"text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"}," View ",8,j)])]))),128))])])])])]),_:1})],64)}const K=_(E,[["render",q],["__scopeId","data-v-f12fb439"]]);export{K as default};
