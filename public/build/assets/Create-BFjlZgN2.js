import{T as N,l as _,m as S,p as V,f as l,a as c,u as r,w as U,F as x,o as a,Z as D,b as t,e as h,d as i,i as n,q as m,t as d,g as u,y as g,s as k}from"./app-C2dyUFtU.js";import{r as q}from"./PlusIcon-B8VJxh30.js";const C={class:"flex justify-center items-center min-h-screen bg-gray-100 p-4"},F={class:"bg-white shadow-lg rounded-lg w-full max-w-3xl",style:{padding:"2rem"}},P={class:"grid grid-cols-1 md:grid-cols-2 gap-6"},T={key:0,class:"text-red-500 text-sm"},j={key:0,class:"text-red-500 text-sm"},B={key:0,class:"text-red-500 text-sm"},L={key:0,class:"text-red-500 text-sm"},M=["value"],E={key:0,class:"text-red-500 text-sm"},A=["disabled"],Z=["value"],z={key:0,class:"text-red-500 text-sm"},G={key:0,class:"text-red-500 text-sm"},H={key:0,class:"text-red-500 text-sm"},I={key:0,class:"text-red-500 text-sm"},J={class:"flex justify-center mt-6"},K=["disabled"],O={key:0},Q={key:1},X={__name:"Create",props:["properties"],setup(w){const s=N({firstName:"",lastName:"",email:"",phone:"",leaseStartDate:"",accountNumber:"",notes:"",property_id:"",unit_id:""}),y=w,p=_([]);S(()=>s.property_id,b=>{if(b){const e=y.properties.find(f=>f.id===b);p.value=e?e.units:[],s.unit_id=""}else p.value=[]});const v=()=>{s.post("/tenants/store",{onFinish:()=>{s.reset()}})};return(b,e)=>{const f=V("app-layout");return a(),l(x,null,[c(r(D),{title:"Create Tenant"}),c(f,null,{default:U(()=>[t("div",C,[t("div",F,[e[20]||(e[20]=t("h1",{class:"text-2xl font-semibold mb-6 text-center"},"Create Tenant",-1)),t("form",{onSubmit:h(v,["prevent"]),class:"space-y-6"},[t("div",P,[t("div",null,[e[9]||(e[9]=t("label",{for:"firstName",class:"block text-sm font-medium text-gray-700"},[i(" First Name "),t("span",{class:"text-red-500"},"*")],-1)),n(t("input",{type:"text",id:"firstName","onUpdate:modelValue":e[0]||(e[0]=o=>r(s).firstName=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},null,512),[[m,r(s).firstName]]),r(s).errors.firstName?(a(),l("span",T,d(r(s).errors.firstName),1)):u("",!0)]),t("div",null,[e[10]||(e[10]=t("label",{for:"lastName",class:"block text-sm font-medium text-gray-700"},[i(" Last Name "),t("span",{class:"text-red-500"},"*")],-1)),n(t("input",{type:"text",id:"lastName","onUpdate:modelValue":e[1]||(e[1]=o=>r(s).lastName=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},null,512),[[m,r(s).lastName]]),r(s).errors.lastName?(a(),l("span",j,d(r(s).errors.lastName),1)):u("",!0)]),t("div",null,[e[11]||(e[11]=t("label",{for:"email",class:"block text-sm font-medium text-gray-700"},[i(" Email "),t("span",{class:"text-red-500"},"*")],-1)),n(t("input",{type:"email",id:"email","onUpdate:modelValue":e[2]||(e[2]=o=>r(s).email=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},null,512),[[m,r(s).email]]),r(s).errors.email?(a(),l("span",B,d(r(s).errors.email),1)):u("",!0)]),t("div",null,[e[12]||(e[12]=t("label",{for:"phone",class:"block text-sm font-medium text-gray-700"},[i(" Phone "),t("span",{class:"text-red-500"},"*")],-1)),n(t("input",{type:"tel",id:"phone","onUpdate:modelValue":e[3]||(e[3]=o=>r(s).phone=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},null,512),[[m,r(s).phone]]),r(s).errors.phone?(a(),l("span",L,d(r(s).errors.phone),1)):u("",!0)]),t("div",null,[e[14]||(e[14]=t("label",{for:"property",class:"block text-sm font-medium text-gray-700"},[i(" Property "),t("span",{class:"text-red-500"},"*")],-1)),n(t("select",{id:"property","onUpdate:modelValue":e[4]||(e[4]=o=>r(s).property_id=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},[e[13]||(e[13]=t("option",{value:""},"Select Property",-1)),(a(!0),l(x,null,k(y.properties,o=>(a(),l("option",{key:o.id,value:o.id},d(o.propertyName),9,M))),128))],512),[[g,r(s).property_id]]),r(s).errors.property_id?(a(),l("span",E,d(r(s).errors.property_id),1)):u("",!0)]),t("div",null,[e[16]||(e[16]=t("label",{for:"unit",class:"block text-sm font-medium text-gray-700"},[i(" Unit "),t("span",{class:"text-red-500"},"*")],-1)),n(t("select",{id:"unit","onUpdate:modelValue":e[5]||(e[5]=o=>r(s).unit_id=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:"",disabled:p.value.length===0},[e[15]||(e[15]=t("option",{value:""},"Select Unit",-1)),(a(!0),l(x,null,k(p.value,o=>(a(),l("option",{key:o.id,value:o.id},d(o.name),9,Z))),128))],8,A),[[g,r(s).unit_id]]),r(s).errors.unit_id?(a(),l("span",z,d(r(s).errors.unit_id),1)):u("",!0)]),t("div",null,[e[17]||(e[17]=t("label",{for:"leaseStartDate",class:"block text-sm font-medium text-gray-700"},[i(" Lease Start Date "),t("span",{class:"text-red-500"},"*")],-1)),n(t("input",{type:"date",id:"leaseStartDate","onUpdate:modelValue":e[6]||(e[6]=o=>r(s).leaseStartDate=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",required:""},null,512),[[m,r(s).leaseStartDate]]),r(s).errors.leaseStartDate?(a(),l("span",G,d(r(s).errors.leaseStartDate),1)):u("",!0)]),t("div",null,[e[18]||(e[18]=t("label",{for:"account_number",class:"block text-sm font-medium text-gray-700"},[i(" Account Number "),t("span",{class:"text-gray-500"},"(optional)")],-1)),n(t("input",{type:"text",id:"account_number","onUpdate:modelValue":e[7]||(e[7]=o=>r(s).accountNumber=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",min:"1",max:"31"},null,512),[[m,r(s).accountNumber]]),r(s).errors.accountNumber?(a(),l("span",H,d(r(s).errors.accountNumber),1)):u("",!0)])]),t("div",null,[e[19]||(e[19]=t("label",{for:"notes",class:"block text-sm font-medium text-gray-700"},"Notes",-1)),n(t("textarea",{id:"notes","onUpdate:modelValue":e[8]||(e[8]=o=>r(s).notes=o),class:"mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500",rows:"3"},null,512),[[m,r(s).notes]]),r(s).errors.notes?(a(),l("span",I,d(r(s).errors.notes),1)):u("",!0)]),t("div",J,[t("button",{type:"submit",class:"flex justify-between px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out",disabled:r(s).processing},[c(r(q),{class:"w-5 h-5 mr-2"}),r(s).processing?(a(),l("span",Q,"Processing...")):(a(),l("span",O,"Submit"))],8,K)])],32)])])]),_:1})],64)}}};export{X as default};