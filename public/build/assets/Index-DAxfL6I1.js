import{Q as c,l as n,T as U,p as M,f as p,a as y,u as l,w as S,F as f,o as u,Z as V,b as e,e as C,i,q as x,v as F,y as T,t as a,s as q}from"./app-C2dyUFtU.js";const E={class:"max-w-6xl mx-auto py-12"},N={class:"bg-white shadow-md rounded-lg p-6"},A={class:"mb-4"},B={class:"mb-4"},D={for:"status",class:"inline-flex items-center"},L={class:"mb-4"},P={class:"mb-4"},I={type:"submit",class:"w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"},K={class:"mt-8"},O={class:"min-w-full border border-gray-300"},Q={class:"px-4 py-2 border"},R={class:"px-4 py-2 border"},Z={class:"px-4 py-2 border"},$={class:"px-4 py-2 border"},j={class:"px-4 py-2 border"},z={class:"px-4 py-2 border"},G=["onClick"],X={__name:"Index",setup(H){const{utilities:_}=c().props,m=n(_),d=n(!1),b=n(!1),s=U({id:null,name:"",status:!1,fee_type:"monthly",price:null}),v=async()=>{b.value=!0,s.errors={};try{d.value?await s.put(route("utilities.update",s.id)):await s.post(route("utilities.store")),m.value=c().props.utilities,h()}catch(r){console.error(r),s.errors=r.response.data.errors||{}}finally{b.value=!1}},h=()=>{s.reset(),d.value=!1},w=r=>{s.id=r.id,s.name=r.name,s.status=!!r.status,s.fee_type=r.fee_type,s.price=r.price,d.value=!0};return(r,t)=>{const g=M("app-layout");return u(),p(f,null,[y(l(V),{title:"Utilities"}),y(g,null,{default:S(()=>[e("div",E,[e("div",N,[t[11]||(t[11]=e("h1",{class:"text-2xl font-semibold mb-4"},"Manage Utilities",-1)),e("form",{onSubmit:C(v,["prevent"])},[e("div",A,[t[4]||(t[4]=e("label",{for:"name",class:"block text-sm font-medium text-gray-700"},"Utility Name",-1)),i(e("input",{type:"text",id:"name","onUpdate:modelValue":t[0]||(t[0]=o=>l(s).name=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},null,512),[[x,l(s).name]])]),e("div",B,[e("label",D,[i(e("input",{type:"checkbox",id:"status","onUpdate:modelValue":t[1]||(t[1]=o=>l(s).status=o),class:"form-checkbox h-4 w-4 text-blue-600"},null,512),[[F,l(s).status]]),t[5]||(t[5]=e("span",{class:"ml-2 text-gray-700"},"Active",-1))])]),e("div",L,[t[7]||(t[7]=e("label",{for:"fee_type",class:"block text-sm font-medium text-gray-700"},"Fee Type",-1)),i(e("select",{id:"fee_type","onUpdate:modelValue":t[2]||(t[2]=o=>l(s).fee_type=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},t[6]||(t[6]=[e("option",{value:"one_time"},"One Time",-1),e("option",{value:"renewable"},"Renewable",-1),e("option",{value:"monthly"},"Monthly",-1)]),512),[[T,l(s).fee_type]])]),e("div",P,[t[8]||(t[8]=e("label",{for:"price",class:"block text-sm font-medium text-gray-700"},"Price",-1)),i(e("input",{type:"number",id:"price","onUpdate:modelValue":t[3]||(t[3]=o=>l(s).price=o),step:"0.01",min:"0",class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2",required:""},null,512),[[x,l(s).price]])]),e("div",null,[e("button",I,a(l(s).id?"Update Utility":"Add Utility"),1)])],32),e("div",K,[t[10]||(t[10]=e("h2",{class:"text-lg font-semibold mb-4"},"Utilities List",-1)),e("table",O,[t[9]||(t[9]=e("thead",null,[e("tr",{class:"bg-gray-100"},[e("th",{class:"px-4 py-2 border"},"#"),e("th",{class:"px-4 py-2 border"},"Name"),e("th",{class:"px-4 py-2 border"},"Status"),e("th",{class:"px-4 py-2 border"},"Fee Type"),e("th",{class:"px-4 py-2 border"},"Price"),e("th",{class:"px-4 py-2 border"},"Actions")])],-1)),e("tbody",null,[(u(!0),p(f,null,q(m.value.data,(o,k)=>(u(),p("tr",{key:o.id},[e("td",Q,a(k+1),1),e("td",R,a(o.name),1),e("td",Z,a(o.status),1),e("td",$,a(o.fee_type),1),e("td",j,"KES "+a(o.price),1),e("td",z,[e("button",{onClick:J=>w(o),class:"text-blue-500 hover:text-blue-700"}," Edit ",8,G)])]))),128))])])])])])]),_:1})],64)}}};export{X as default};
