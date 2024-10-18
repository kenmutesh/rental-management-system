import{o as r,c as w,a as s,l as c,Q as z,h as C,m as M,p as v,f as h,u as a,w as p,F as f,Z as E,b as e,k as m,d as g,t as o,i as N,q as $,s as j,x as A}from"./app-C2dyUFtU.js";import{r as D}from"./PlusIcon-B8VJxh30.js";function F(u,i){return r(),w("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[s("path",{d:"M12 14l9-5-9-5-9 5 9 5z"}),s("path",{d:"M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"}),s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"})])}function H(u,i){return r(),w("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"})])}function U(u,i){return r(),w("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"})])}const K={class:"flex mb-6"},P={class:"container mx-auto px-4"},Q={class:"grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"},q={class:"bg-white shadow-md rounded-lg p-4 flex items-center"},I={class:"text-2xl"},R={class:"bg-white shadow-md rounded-lg p-4 flex items-center"},Z={class:"text-2xl"},G={class:"bg-white shadow-md rounded-lg p-4 flex items-center"},J={class:"text-2xl"},O={class:"mb-4"},W={class:"bg-white shadow-md rounded-lg"},X={class:"min-w-full divide-y divide-gray-200"},Y={class:"bg-white divide-y divide-gray-200"},ee={class:"px-6 py-4 whitespace-nowrap"},te={class:"px-6 py-4 whitespace-nowrap"},se={class:"px-6 py-4 whitespace-nowrap"},ae={class:"px-6 py-4 whitespace-nowrap"},ne={class:"py-4 px-6"},oe={class:"mt-4"},ie={__name:"Index",setup(u){const i=c({totalBalance:5e3,defaultLeases:5}),{search:_,page:y,totalTenants:b,tenants:k}=z().props,B=c(y||1),d=c(_||""),x=c(d.value?[]:k),T=C(()=>{let l=new URL(route("tenants.index"));return l.searchParams.append("page",B.value),d.value&&l.searchParams.append("search",d.value),l});return M(()=>T.value,l=>{A.replace(l,{preserveScroll:!0,preserveState:!0,replace:!0,method:"get",onSuccess:t=>{x.value=t.props.tenants}})}),(l,t)=>{const L=v("app-pagination"),S=v("app-layout");return r(),h(f,null,[s(a(E),{title:"Tenants"}),s(S,null,{default:p(()=>[e("div",K,[s(a(m),{href:"/tenants/create",class:"flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 ml-auto"},{default:p(()=>[s(a(D),{class:"w-5 h-5 mr-2"}),t[1]||(t[1]=g(" Create Tenant "))]),_:1})]),e("div",P,[e("div",Q,[e("div",q,[s(a(F),{class:"h-16 w-16 text-blue-500 mr-2"}),e("div",null,[t[2]||(t[2]=e("h2",{class:"text-lg font-semibold"},"Total Tenants",-1)),e("p",I,o(a(b)),1)])]),e("div",R,[s(a(H),{class:"h-16 w-16 text-green-500 mr-2"}),e("div",null,[t[3]||(t[3]=e("h2",{class:"text-lg font-semibold"},"Total Balance",-1)),e("p",Z,"KES "+o(i.value.totalBalance),1)])]),e("div",G,[s(a(U),{class:"h-16 w-16 text-yellow-500 mr-2"}),e("div",null,[t[4]||(t[4]=e("h2",{class:"text-lg font-semibold"},"Default Leases",-1)),e("p",J,o(i.value.defaultLeases),1)])])]),e("div",O,[N(e("input",{"onUpdate:modelValue":t[0]||(t[0]=n=>d.value=n),type:"text",placeholder:"Search tenants...",class:"w-full px-4 py-2 border rounded-lg"},null,512),[[$,d.value]])]),e("div",W,[e("table",X,[t[7]||(t[7]=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"#"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Tenant Name"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Balance"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Lease Expiration"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Action")])],-1)),e("tbody",Y,[(r(!0),h(f,null,j(x.value.data,(n,V)=>(r(),h("tr",{key:n.id},[e("td",ee,o(V+1),1),e("td",te,o(n.name),1),e("td",se,"KES "+o(n.balance),1),e("td",ae,o(n.lease_expiration),1),e("td",ne,[s(a(m),{href:`/tenants/invoices/${n.id}`,class:"text-blue-500 hover:text-blue-700 font-semibold mr-4"},{default:p(()=>t[5]||(t[5]=[g(" View invoices ")])),_:2},1032,["href"]),s(a(m),{href:`/tenants/edit/${n.id}`,class:"text-red-500 hover:text-red-700 font-semibold mr-4"},{default:p(()=>t[6]||(t[6]=[g(" Edit ")])),_:2},1032,["href"])])]))),128))])])]),e("div",oe,[s(L,{pagination:x.value.meta},null,8,["pagination"])])])]),_:1})],64)}}};export{ie as default};