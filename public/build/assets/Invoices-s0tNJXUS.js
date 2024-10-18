import{Q as h,l as n,m as _,p as k,f as c,a as d,u as i,w as D,F as f,o as u,Z as P,b as e,i as m,q as v,s as S,y as C,t as o}from"./app-C2dyUFtU.js";import{r as F,a as V,b as $,c as T}from"./DatabaseIcon-c3v003D3.js";const B={class:"container mx-auto px-4 py-6"},I={class:"grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6"},M={class:"bg-white shadow rounded-lg p-6 flex items-center"},U={class:"bg-white shadow rounded-lg p-6 flex items-center"},N={class:"grid grid-cols-1 lg:grid-cols-4 gap-6"},R={class:"bg-white shadow rounded-lg p-6 lg:col-span-1"},j={class:"grid grid-cols-1 gap-6"},q={class:"bg-white shadow overflow-hidden rounded-lg lg:col-span-3"},A={class:"min-w-full"},E={class:"bg-white divide-y divide-gray-200"},L={class:"px-6 py-4 whitespace-nowrap"},Q={class:"px-6 py-4 whitespace-nowrap"},Z={class:"px-6 py-4 whitespace-nowrap"},z={class:"px-6 py-4 whitespace-nowrap"},G={class:"inline-flex items-center px-2 py-0.5 rounded-full text-sm font-medium {{ message.status === 'Success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"},H={class:"px-6 py-4 whitespace-nowrap"},J={class:"flex justify-between items-center mt-4"},K={class:"flex items-center space-x-2"},O=["disabled"],W={class:"text-sm"},X=["disabled"],te={__name:"Invoices",setup(Y){const{invoices:y}=h().props,r=n(""),p=n(""),l=n(1),g=n(5);function x(a){l.value=a}return _([r,p],()=>{}),(a,s)=>{const w=k("app-layout");return u(),c(f,null,[d(i(P),{title:"Communication"}),d(w,null,{default:D(()=>[e("div",B,[e("div",I,[e("div",M,[d(i(F),{class:"h-12 w-12 text-blue-500"}),s[5]||(s[5]=e("div",{class:"ml-4"},[e("h3",{class:"text-lg font-semibold"},"Total Invoices"),e("p",{class:"text-gray-500"},"2 Invoices")],-1))]),e("div",U,[d(i(V),{class:"h-12 w-12 text-green-500"}),s[6]||(s[6]=e("div",{class:"ml-4"},[e("h3",{class:"text-lg font-semibold"},"Pending payments"),e("p",{class:"text-gray-500"},"200 messages sent")],-1))])]),e("div",N,[e("div",R,[s[9]||(s[9]=e("h3",{class:"text-lg font-semibold mb-4"},"Filter by Date",-1)),e("div",j,[e("div",null,[s[7]||(s[7]=e("label",{for:"fromDate",class:"block text-sm font-medium text-gray-700"},"From:",-1)),m(e("input",{type:"date",id:"fromDate","onUpdate:modelValue":s[0]||(s[0]=t=>r.value=t),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm"},null,512),[[v,r.value]])]),e("div",null,[s[8]||(s[8]=e("label",{for:"toDate",class:"block text-sm font-medium text-gray-700"},"To:",-1)),m(e("input",{type:"date",id:"toDate","onUpdate:modelValue":s[1]||(s[1]=t=>p.value=t),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm"},null,512),[[v,p.value]])])])]),e("div",q,[e("table",A,[s[10]||(s[10]=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"}," # "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Recipient "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Message "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Status "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Date Sent "),e("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Action ")])],-1)),e("tbody",E,[(u(!0),c(f,null,S(i(y).data,(t,b)=>(u(),c("tr",{key:t.id},[e("td",L,o(b+1),1),e("td",Q,o(a.message.name),1),e("td",Z,o(a.message.message),1),e("td",z,[e("span",G,o(a.message.status==="Success"?"Success":"Failed"),1)]),e("td",H,o(a.message.created_at),1)]))),128))])])])]),e("div",J,[e("div",null,[s[12]||(s[12]=e("label",{for:"rowsPerPage",class:"text-sm text-gray-700"},"Rows per page:",-1)),m(e("select",{id:"rowsPerPage","onUpdate:modelValue":s[2]||(s[2]=t=>g.value=t),class:"ml-2 text-sm border-gray-300 rounded-md"},s[11]||(s[11]=[e("option",{value:"5"},"5",-1),e("option",{value:"10"},"10",-1),e("option",{value:"30"},"30",-1)]),512),[[C,g.value]])]),e("div",K,[e("button",{onClick:s[3]||(s[3]=t=>x(l.value-1)),disabled:l.value===1,class:"disabled:opacity-50"},[d(i($),{class:"h-5 w-5"})],8,O),e("span",W,o(l.value)+" / "+o(a.totalPages),1),e("button",{onClick:s[4]||(s[4]=t=>x(l.value+1)),disabled:l.value===a.totalPages,class:"disabled:opacity-50"},[d(i(T),{class:"h-5 w-5"})],8,X)])])])]),_:1})],64)}}};export{te as default};
