import{o as d,c as h,a as r,Q as M,l as B,h as P,p as U,f as g,u as s,Z as V,w as x,b as t,j as p,d as m,t as l,i as N,q as T,F as f,s as $}from"./app-CBCFuNEC.js";import{r as j}from"./OfficeBuildingIcon-MBvScQnx.js";import{r as k}from"./PlusIcon-DqAHAPAF.js";/* empty css            */function z(c,o){return d(),h("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[r("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"})])}function A(c,o){return d(),h("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[r("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])}function D(c,o){return d(),h("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[r("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"})])}const L={class:"flex justify-between mb-6"},S={class:"grid grid-cols-1 md:grid-cols-3 gap-4 mb-8"},E={class:"p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800"},F={class:"text-2xl font-bold text-blue-500"},H={class:"p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800"},I={class:"text-2xl font-bold text-blue-500"},Q={class:"p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800"},q={class:"text-2xl font-bold text-blue-500"},Z={class:"flex items-center mb-4"},G={class:"overflow-x-auto"},J={class:"min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg"},K={class:"py-4 px-6 text-sm text-gray-700 dark:text-gray-300"},O={class:"py-4 px-6 text-sm text-gray-700 dark:text-gray-300"},R={class:"py-4 px-6 text-sm text-gray-700 dark:text-gray-300"},W={class:"py-4 px-6 text-sm text-gray-700 dark:text-gray-300"},X={class:"py-4 px-6"},Y=["onClick"],ot={__name:"Index",setup(c){const{properties:o,vacancies:v,totalUnits:y,totalProperties:b}=M().props,u=B(""),w=P(()=>o.data.filter(i=>i.propertyName.toLowerCase().includes(u.value.toLowerCase()))),_=i=>{Inertia.delete(route("properties.destroy",i),{onSuccess:()=>{b.value=o.length,y.value=o.reduce((e,n)=>e+n.totalUnits,0),totalVacancies.value=o.reduce((e,n)=>e+n.vacant,0)}})};return(i,e)=>{const n=U("app-layout");return d(),g(f,null,[r(s(V),{title:"Property Management"}),r(n,null,{default:x(()=>[t("div",L,[r(s(p),{href:"/properties/create",class:"flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 dark:text-white"},{default:x(()=>[r(s(k),{class:"w-5 h-5 mr-2"}),e[1]||(e[1]=m(" Create Property "))]),_:1}),r(s(p),{href:"/units/create",class:"flex items-center bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-white"},{default:x(()=>[r(s(k),{class:"w-5 h-5 mr-2"}),e[2]||(e[2]=m(" Add Unit "))]),_:1})]),t("div",S,[t("div",E,[r(s(j),{class:"w-10 h-10 text-blue-500 mr-4"}),t("div",null,[e[3]||(e[3]=t("h3",{class:"text-lg font-semibold text-gray-700 dark:text-gray-300"},"Total Properties",-1)),t("p",F,l(s(b)),1)])]),t("div",H,[r(s(z),{class:"w-10 h-10 text-blue-500 mr-4"}),t("div",null,[e[4]||(e[4]=t("h3",{class:"text-lg font-semibold text-gray-700 dark:text-gray-300"},"Total Units",-1)),t("p",I,l(s(y)),1)])]),t("div",Q,[r(s(D),{class:"w-10 h-10 text-blue-500 mr-4"}),t("div",null,[e[5]||(e[5]=t("h3",{class:"text-lg font-semibold text-gray-700 dark:text-gray-300"},"Total Vacancies",-1)),t("p",q,l(s(v)),1)])])]),t("div",Z,[r(s(A),{class:"w-5 h-5 text-gray-500 dark:text-gray-400 mr-2"}),N(t("input",{"onUpdate:modelValue":e[0]||(e[0]=a=>u.value=a),type:"text",placeholder:"Search properties...",class:"border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg py-2 px-4 w-full focus:ring focus:ring-blue-200 focus:outline-none dark:focus:ring-blue-500"},null,512),[[T,u.value]])]),t("div",G,[t("table",J,[e[7]||(e[7]=t("thead",null,[t("tr",{class:"bg-gray-100 dark:bg-gray-700"},[t("th",{class:"py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300"},"#"),t("th",{class:"py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300"},"Property Name"),t("th",{class:"py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300"},"Total Units"),t("th",{class:"py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300"},"Vacancies"),t("th",{class:"py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300"},"Actions")])],-1)),t("tbody",null,[(d(!0),g(f,null,$(w.value,(a,C)=>(d(),g("tr",{key:a.id,class:"border-t dark:border-gray-700"},[t("td",K,l(C+1),1),t("td",O,l(a.propertyName),1),t("td",R,l(a.totalUnits),1),t("td",W,l(a.vacancies),1),t("td",X,[r(s(p),{href:`/properties/edit/${a.id}`,class:"text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600 font-semibold mr-4"},{default:x(()=>e[6]||(e[6]=[m(" Edit ")])),_:2},1032,["href"]),t("button",{class:"text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 font-semibold",onClick:tt=>_(a.id)},"Delete",8,Y)])]))),128))])])])]),_:1})],64)}}};export{ot as default};
