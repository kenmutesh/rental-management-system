import{o,c as I,a as n,Q as M,l as i,m as N,C as S,p as V,f as s,u as g,Z as A,w as B,b as e,d as h,i as w,y as _,F as p,s as v,t as u,x as D}from"./app-CBCFuNEC.js";import{_ as j}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */function F(f,m){return o(),I("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[n("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M15 12a3 3 0 11-6 0 3 3 0 016 0z"}),n("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"})])}function Y(f,m){return o(),I("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[n("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"})])}const J={class:"container mx-auto px-4 py-6"},P={class:"mt-6 flex justify-end"},U={class:"mb-6 flex justify-between items-center mt-6"},z={class:"flex space-x-4"},L=["value"],$=["value"],E={class:"overflow-x-auto shadow-lg rounded-lg"},O={key:0,class:"min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500"},Q={class:"px-4 dark:text-gray-200 py-2"},T={class:"px-4 dark:text-gray-200 py-2"},Z={class:"px-4 dark:text-gray-200 py-2"},q={class:"px-4 dark:text-gray-200 py-2"},G={class:"px-4 dark:text-gray-200 py-2"},H=["onClick"],K={key:1,class:"p-6 text-center text-gray-500 dark:text-gray-300"},R={__name:"Index",setup(f){const{invoices:m}=M().props,l=i(""),d=i(""),k=i([]),C=i(["January","February","March","April","May","June","July","August","September","October","November","December"]),c=i(m),b=()=>{D.get(route("invoices.index"),{year:l.value,month:d.value},{preserveState:!0,preserveScroll:!0,replace:!0,onSuccess:a=>{c.value=a.props.invoices}})};return N([l,d],()=>{l.value&&d.value&&b()}),S(()=>{const a=new Date().getFullYear();l.value=a,d.value=new Date().getMonth()+1,k.value=Array.from({length:5},(t,x)=>a-x),b()}),(a,t)=>{const x=V("app-layout");return o(),s(p,null,[n(g(A),{title:"Invoices"}),n(x,null,{default:B(()=>[e("div",J,[t[10]||(t[10]=e("div",{class:"mb-6 text-center"},[e("h1",{class:"text-3xl font-semibold text-gray-900 dark:text-gray-100"}," View All Invoices "),e("p",{class:"text-gray-500 dark:text-gray-300"},"Manage and upload payments for all your invoices.")],-1)),e("div",P,[e("button",{onClick:t[0]||(t[0]=(...r)=>a.uploadPayments&&a.uploadPayments(...r)),class:"flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"},[n(g(Y),{class:"w-5 h-5 mr-2"}),t[5]||(t[5]=h(" Upload Payments "))])]),e("div",U,[e("div",z,[e("div",null,[t[6]||(t[6]=e("label",{for:"year",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"Year",-1)),w(e("select",{id:"year","onUpdate:modelValue":t[1]||(t[1]=r=>l.value=r),onChange:t[2]||(t[2]=(...r)=>a.filterInvoices&&a.filterInvoices(...r)),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},[(o(!0),s(p,null,v(k.value,r=>(o(),s("option",{key:r,value:r},u(r),9,L))),128))],544),[[_,l.value]])]),e("div",null,[t[7]||(t[7]=e("label",{for:"month",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"Month",-1)),w(e("select",{id:"month","onUpdate:modelValue":t[3]||(t[3]=r=>d.value=r),onChange:t[4]||(t[4]=(...r)=>a.filterInvoices&&a.filterInvoices(...r)),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"},[(o(!0),s(p,null,v(C.value,(r,y)=>(o(),s("option",{key:y,value:y+1},u(r),9,$))),128))],544),[[_,d.value]])])])]),e("div",E,[c.value.data&&c.value.data.length>0?(o(),s("table",O,[t[9]||(t[9]=e("thead",null,[e("tr",null,[e("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Invoice #"),e("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Client Name"),e("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Amount"),e("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Status"),e("th",{class:"px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100"},"Actions")])],-1)),e("tbody",null,[(o(!0),s(p,null,v(c.value.data,r=>(o(),s("tr",{key:r.id},[e("td",Q,u(r.month),1),e("td",T,u(r.tenantName),1),e("td",Z,u(r.amount),1),e("td",q,u(r.status),1),e("td",G,[e("button",{onClick:y=>a.openInvoiceDetails(r.id),class:"flex gap-2 text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"},[n(g(F),{class:"w-5 h-5"}),t[8]||(t[8]=h(" View "))],8,H)])]))),128))])])):(o(),s("div",K," No invoices found for the selected month. "))])])]),_:1})],64)}}},te=j(R,[["__scopeId","data-v-f43075af"]]);export{te as default};
