import{T as h,l as k,Q as S,m as q,p as D,o,f as d,a as x,u as s,w as U,F as c,Z as V,b as r,e as F,d as m,i,q as b,t as l,g as n,y as v,s as w}from"./app-C9tt9wBd.js";import{r as P}from"./PlusIcon-BzsysLAe.js";const C={class:"flex justify-center items-center min-h-screen p-4"},L={class:"bg-white dark:bg-gray-700 shadow-lg rounded-lg w-full max-w-3xl",style:{padding:"2rem"}},T={class:"grid grid-cols-1 md:grid-cols-2 gap-6"},j={key:0,class:"text-red-500 text-sm"},B={key:0,class:"text-red-500 text-sm"},E={key:0,class:"text-red-500 text-sm"},M={key:0,class:"text-red-500 text-sm"},A=["value"],O={key:0,class:"text-red-500 text-sm"},Q=["disabled"],Z=["value","disabled"],z={key:0,class:"text-red-500 text-sm"},G={key:0,class:"text-red-500 text-sm"},H={key:0,class:"text-red-500 text-sm"},I={key:0,class:"text-red-500 text-sm"},J={class:"flex justify-center mt-6"},K=["disabled"],R={key:0},W={key:1},ee={__name:"Create",setup(X){const e=h({firstName:"",lastName:"",email:"",phone:"",leaseStartDate:"",accountNumber:"",notes:"",property_id:"",unit_id:""}),u=k({firstName:"",lastName:"",email:"",phone:"",property_id:"",unit_id:"",leaseStartDate:""}),N=()=>(u.value.firstName=e.firstName?"":"First name is required",u.value.lastName=e.lastName?"":"Last name is required",u.value.email=e.email?"":"Email is required",u.value.phone=e.phone?"":"Phone is required",u.value.property_id=e.property_id?"":"Property is required",u.value.unit_id=e.unit_id?"":"Unit is required",u.value.leaseStartDate=e.leaseStartDate?"":"Lease start date is required",Object.values(u.value).every(p=>p==="")),{properties:f}=S().props,y=k([]);q(()=>e.property_id,p=>{if(p){const t=f.data.find(g=>g.id===p);y.value=t?t.units:[],e.unit_id=""}else y.value=[]});const _=()=>{N()&&e.post("/tenants/store",{onFinish:()=>{e.reset()}})};return(p,t)=>{const g=D("app-layout");return o(),d(c,null,[x(s(V),{title:"Create Tenant"}),x(g,null,{default:U(()=>[r("div",C,[r("div",L,[t[20]||(t[20]=r("h1",{class:"text-2xl font-semibold mb-6 text-center text-gray-900 dark:text-gray-100"},"Create Tenant",-1)),r("form",{onSubmit:F(_,["prevent"]),class:"space-y-6"},[r("div",T,[r("div",null,[t[9]||(t[9]=r("label",{for:"firstName",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" First Name "),r("span",{class:"text-red-500"},"*")],-1)),i(r("input",{type:"text",id:"firstName","onUpdate:modelValue":t[0]||(t[0]=a=>s(e).firstName=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},null,512),[[b,s(e).firstName]]),s(e).errors.firstName?(o(),d("span",j,l(s(e).errors.firstName),1)):n("",!0)]),r("div",null,[t[10]||(t[10]=r("label",{for:"lastName",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Last Name "),r("span",{class:"text-red-500"},"*")],-1)),i(r("input",{type:"text",id:"lastName","onUpdate:modelValue":t[1]||(t[1]=a=>s(e).lastName=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},null,512),[[b,s(e).lastName]]),s(e).errors.lastName?(o(),d("span",B,l(s(e).errors.lastName),1)):n("",!0)]),r("div",null,[t[11]||(t[11]=r("label",{for:"email",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Email "),r("span",{class:"text-red-500"},"*")],-1)),i(r("input",{type:"email",id:"email","onUpdate:modelValue":t[2]||(t[2]=a=>s(e).email=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},null,512),[[b,s(e).email]]),s(e).errors.email?(o(),d("span",E,l(s(e).errors.email),1)):n("",!0)]),r("div",null,[t[12]||(t[12]=r("label",{for:"phone",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Phone "),r("span",{class:"text-red-500"},"*")],-1)),i(r("input",{type:"tel",id:"phone","onUpdate:modelValue":t[3]||(t[3]=a=>s(e).phone=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},null,512),[[b,s(e).phone]]),s(e).errors.phone?(o(),d("span",M,l(s(e).errors.phone),1)):n("",!0)]),r("div",null,[t[14]||(t[14]=r("label",{for:"property",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Property "),r("span",{class:"text-red-500"},"*")],-1)),i(r("select",{id:"property","onUpdate:modelValue":t[4]||(t[4]=a=>s(e).property_id=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},[t[13]||(t[13]=r("option",{value:""},"Select Property",-1)),(o(!0),d(c,null,w(s(f).data,a=>(o(),d("option",{key:a.id,value:a.id},l(a.propertyName),9,A))),128))],512),[[v,s(e).property_id]]),s(e).errors.property_id?(o(),d("span",O,l(s(e).errors.property_id),1)):n("",!0)]),r("div",null,[t[16]||(t[16]=r("label",{for:"unit",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Unit "),r("span",{class:"text-red-500"},"*")],-1)),i(r("select",{id:"unit","onUpdate:modelValue":t[5]||(t[5]=a=>s(e).unit_id=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:"",disabled:y.value.length===0},[t[15]||(t[15]=r("option",{disabled:"",value:""},"Select Unit",-1)),(o(!0),d(c,null,w(y.value,a=>(o(),d("option",{key:a.id,value:a.id,disabled:a.status==="occupied"},l(a.name)+" - "+l(a.status==="occupied"?"occupied":a.rentAmount),9,Z))),128))],8,Q),[[v,s(e).unit_id]]),s(e).errors.unit_id?(o(),d("span",z,l(s(e).errors.unit_id),1)):n("",!0)]),r("div",null,[t[17]||(t[17]=r("label",{for:"leaseStartDate",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Lease Start Date "),r("span",{class:"text-red-500"},"*")],-1)),i(r("input",{type:"date",id:"leaseStartDate","onUpdate:modelValue":t[6]||(t[6]=a=>s(e).leaseStartDate=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",required:""},null,512),[[b,s(e).leaseStartDate]]),s(e).errors.leaseStartDate?(o(),d("span",G,l(s(e).errors.leaseStartDate),1)):n("",!0)]),r("div",null,[t[18]||(t[18]=r("label",{for:"account_number",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},[m(" Account Number "),r("span",{class:"text-gray-500"},"(optional)")],-1)),i(r("input",{type:"text",id:"account_number","onUpdate:modelValue":t[7]||(t[7]=a=>s(e).accountNumber=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",min:"1",max:"31"},null,512),[[b,s(e).accountNumber]]),s(e).errors.accountNumber?(o(),d("span",H,l(s(e).errors.accountNumber),1)):n("",!0)])]),r("div",null,[t[19]||(t[19]=r("label",{for:"notes",class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},"Notes",-1)),i(r("textarea",{id:"notes","onUpdate:modelValue":t[8]||(t[8]=a=>s(e).notes=a),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500",rows:"3"},null,512),[[b,s(e).notes]]),s(e).errors.notes?(o(),d("span",I,l(s(e).errors.notes),1)):n("",!0)]),r("div",J,[r("button",{type:"submit",class:"flex justify-between px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800",disabled:s(e).processing},[x(s(P),{class:"w-5 h-5 mr-2"}),s(e).processing?(o(),d("span",W,"Processing...")):(o(),d("span",R,"Submit"))],8,K)])],32)])])]),_:1})],64)}}};export{ee as default};