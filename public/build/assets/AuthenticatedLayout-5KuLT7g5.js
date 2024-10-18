import{l as v,o,f as n,b as e,n as i,g as d,e as p,j as f,r as x,x as h}from"./app-C2dyUFtU.js";import{_ as w}from"./_plugin-vue_export-helper-DlAUqK2U.js";const c={class:"min-h-screen flex bg-gray-100"},g={class:"p-2"},m={class:"flex flex-col space-y-2"},y={key:0,class:"pl-10 transition-all duration-300"},k={key:0,class:"pl-10 transition-all duration-300"},C={key:0,class:"pl-10 transition-all duration-300"},j={class:"flex-1 flex flex-col"},B={class:"border-b border-gray-200 bg-white sticky top-0 z-10"},M={class:"mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"},L={class:"flex h-16 justify-between items-center"},$={class:"flex"},z={key:0,class:"h-6 w-6",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},S={key:1,class:"h-6 w-6",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},N={class:"flex-1 m-2"},P={__name:"AuthenticatedLayout",setup(U){const b=()=>{h.post("/logout")},l=v(!1),s=v(null),u=a=>{s.value=s.value===a?null:a};return(a,t)=>(o(),n("div",c,[e("aside",{class:i([{"translate-x-0":l.value,"-translate-x-full":!l.value},"fixed inset-y-0 left-0 w-64 bg-blue-500 shadow-md transform transition-transform duration-300 ease-in-out z-50 sm:relative sm:translate-x-0"])},[e("div",g,[t[15]||(t[15]=e("a",{href:"/",class:"block mb-6"},[e("img",{src:"/logo.png",alt:"Logo",class:"h-12 w-auto text-white"})],-1)),e("nav",m,[t[11]||(t[11]=e("a",{href:"/dashboard",class:"block py-2 px-4 text-white hover:bg-blue-600 rounded"},"Dashboard",-1)),e("div",null,[e("button",{onClick:t[0]||(t[0]=r=>u(1)),class:"flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded"},[t[5]||(t[5]=e("span",null,"Financials",-1)),e("i",{class:i(s.value===1?"fa fa-chevron-up":"fa fa-chevron-down")},null,2)]),s.value===1?(o(),n("div",y,t[6]||(t[6]=[e("a",{href:"/invoices",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Invoices",-1),e("a",{href:"/payments",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Payments",-1),e("a",{href:"/expenses",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Expenses",-1)]))):d("",!0)]),t[12]||(t[12]=e("a",{href:"/tenants",class:"block py-2 px-4 text-white hover:bg-blue-600 rounded"},"Tenants",-1)),e("div",null,[e("button",{onClick:t[1]||(t[1]=r=>u(2)),class:"flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded"},[t[7]||(t[7]=e("span",null,"Property/Unit",-1)),e("i",{class:i(s.value===2?"fa fa-chevron-up":"fa fa-chevron-down")},null,2)]),s.value===2?(o(),n("div",k,t[8]||(t[8]=[e("a",{href:"/properties",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Properties",-1),e("a",{href:"/units",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Units",-1),e("a",{href:"/utilities",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Utilities",-1)]))):d("",!0)]),t[13]||(t[13]=e("a",{href:"/reports",class:"block py-2 px-4 text-white hover:bg-blue-600 rounded"},"Reports",-1)),t[14]||(t[14]=e("a",{href:"/communication",class:"block py-2 px-4 text-white hover:bg-blue-600 rounded"},"Communication",-1)),e("div",null,[e("button",{onClick:t[2]||(t[2]=r=>u(3)),class:"flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded"},[t[9]||(t[9]=e("span",null,"Settings",-1)),e("i",{class:i(s.value===3?"fa fa-chevron-up":"fa fa-chevron-down")},null,2)]),s.value===3?(o(),n("div",C,t[10]||(t[10]=[e("a",{href:"/general",class:"block py-2 text-white hover:bg-blue-600 rounded"},"General",-1),e("a",{href:"/backup",class:"block py-2 text-white hover:bg-blue-600 rounded"},"Backup",-1)]))):d("",!0)]),e("a",{onClick:p(b,["prevent"]),class:"block py-2 px-4 text-white hover:bg-blue-600 rounded"},"Log Out")])])],2),l.value?(o(),n("div",{key:0,onClick:t[3]||(t[3]=r=>l.value=!1),class:"fixed inset-0 bg-black opacity-50 z-40 sm:hidden"})):d("",!0),e("div",j,[e("nav",B,[e("div",M,[e("div",L,[e("div",$,[e("button",{onClick:t[4]||(t[4]=r=>l.value=!l.value),class:"mr-4 text-gray-500 focus:outline-none sm:hidden"},[l.value?(o(),n("svg",S,t[17]||(t[17]=[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,-1)]))):(o(),n("svg",z,t[16]||(t[16]=[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,-1)])))])]),t[18]||(t[18]=f('<div class="hidden sm:ml-6 sm:flex sm:items-center" data-v-107b08e0><div class="relative ml-3" data-v-107b08e0><div class="inline-flex rounded-md" data-v-107b08e0><button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-v-107b08e0> John Doe <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" data-v-107b08e0><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" data-v-107b08e0></path></svg></button></div></div></div>',1))])])]),e("main",N,[x(a.$slots,"default",{},void 0,!0)])])]))}},D=w(P,[["__scopeId","data-v-107b08e0"]]);export{D as default};