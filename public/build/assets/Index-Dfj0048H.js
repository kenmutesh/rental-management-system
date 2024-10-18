import{Q as c,l as n,T as M,p as S,f as p,a as y,u as r,w as V,F as f,o as u,Z as F,b as e,e as T,i,q as x,v as q,y as E,t as a,s as N}from"./app-IE8USvGh.js";const A={class:"max-w-6xl mx-auto py-12"},B={class:"bg-white shadow-md rounded-lg p-6"},D={class:"mb-4"},L={class:"mb-4"},P={for:"status",class:"inline-flex items-center"},$={class:"mb-4"},I={class:"mb-4"},K={type:"submit",class:"w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"},O={class:"mt-8"},Q={class:"min-w-full border border-gray-300"},R={class:"px-4 py-2 border"},Z={class:"px-4 py-2 border"},j={class:"px-4 py-2 border"},z={class:"px-4 py-2 border"},G={class:"px-4 py-2 border"},H={class:"px-4 py-2 border flex gap-3"},J=["onClick"],W=["onClick"],ee={__name:"Index",setup(X){const{utilities:_}=c().props,m=n(_),d=n(!1),b=n(!1),s=M({id:null,name:"",status:!1,fee_type:"monthly",price:null}),v=async()=>{b.value=!0,s.errors={};try{d.value?await s.put(route("utilities.update",s.id)):await s.post(route("utilities.store")),m.value=c().props.utilities,h()}catch(l){console.error(l),s.errors=l.response.data.errors||{}}finally{b.value=!1}},h=()=>{s.reset(),d.value=!1},w=l=>{s.id=l.id,s.name=l.name,s.status=!!l.status,s.fee_type=l.fee_type,s.price=l.price,d.value=!0},g=async l=>{await s.post(route("utilities.delete",l.id))};return(l,t)=>{const k=S("app-layout");return u(),p(f,null,[y(r(F),{title:"Utilities"}),y(k,null,{default:V(()=>[e("div",A,[e("div",B,[t[11]||(t[11]=e("h1",{class:"text-2xl font-semibold mb-4"},"Manage Utilities",-1)),e("form",{onSubmit:T(v,["prevent"])},[e("div",D,[t[4]||(t[4]=e("label",{for:"name",class:"block text-sm font-medium text-gray-700"},"Utility Name",-1)),i(e("input",{type:"text",id:"name","onUpdate:modelValue":t[0]||(t[0]=o=>r(s).name=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},null,512),[[x,r(s).name]])]),e("div",L,[e("label",P,[i(e("input",{type:"checkbox",id:"status","onUpdate:modelValue":t[1]||(t[1]=o=>r(s).status=o),class:"form-checkbox h-4 w-4 text-blue-600"},null,512),[[q,r(s).status]]),t[5]||(t[5]=e("span",{class:"ml-2 text-gray-700"},"Active",-1))])]),e("div",$,[t[7]||(t[7]=e("label",{for:"fee_type",class:"block text-sm font-medium text-gray-700"},"Fee Type",-1)),i(e("select",{id:"fee_type","onUpdate:modelValue":t[2]||(t[2]=o=>r(s).fee_type=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},t[6]||(t[6]=[e("option",{value:"one_time"},"One Time",-1),e("option",{value:"renewable"},"Renewable",-1),e("option",{value:"monthly"},"Monthly",-1)]),512),[[E,r(s).fee_type]])]),e("div",I,[t[8]||(t[8]=e("label",{for:"price",class:"block text-sm font-medium text-gray-700"},"Price",-1)),i(e("input",{type:"number",id:"price","onUpdate:modelValue":t[3]||(t[3]=o=>r(s).price=o),step:"0.01",min:"0",class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},null,512),[[x,r(s).price]])]),e("div",null,[e("button",K,a(r(s).id?"Update Utility":"Add Utility"),1)])],32),e("div",O,[t[10]||(t[10]=e("h2",{class:"text-lg font-semibold mb-4"},"Utilities List",-1)),e("table",Q,[t[9]||(t[9]=e("thead",null,[e("tr",{class:"bg-gray-100"},[e("th",{class:"px-4 py-2 border"},"#"),e("th",{class:"px-4 py-2 border"},"Name"),e("th",{class:"px-4 py-2 border"},"Status"),e("th",{class:"px-4 py-2 border"},"Fee Type"),e("th",{class:"px-4 py-2 border"},"Price"),e("th",{class:"px-4 py-2 border"},"Actions")])],-1)),e("tbody",null,[(u(!0),p(f,null,N(m.value.data,(o,U)=>(u(),p("tr",{key:o.id},[e("td",R,a(U+1),1),e("td",Z,a(o.name),1),e("td",j,a(o.status),1),e("td",z,a(o.fee_type),1),e("td",G,"KES "+a(o.price),1),e("td",H,[e("button",{onClick:C=>w(o),class:"text-blue-500 hover:text-blue-700"}," Edit ",8,J),e("button",{onClick:C=>g(o),class:"text-red-500 hover:text-red-700"}," Delete ",8,W)])]))),128))])])])])])]),_:1})],64)}}};export{ee as default};
