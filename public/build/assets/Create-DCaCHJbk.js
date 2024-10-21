import{Q as P,l as w,T as h,C as U,p as R,o as d,f as i,a as b,u as a,w as E,F as V,Z as C,b as t,t as p,e as T,d as u,i as s,q as n,g as c}from"./app-BtpFdyZw.js";import{r as I}from"./PlusIcon-AvNWEKMV.js";import{_ as M}from"./_plugin-vue_export-helper-DlAUqK2U.js";const S={class:"max-w-6xl mx-auto py-12"},q={class:"bg-white dark:bg-gray-800 shadow-md rounded-lg p-6"},B={class:"text-xl font-bold mb-6 text-gray-900 dark:text-gray-100"},F={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4"},D={key:0,class:"text-red-600 dark:text-red-400 text-sm"},j={key:0,class:"text-red-600 dark:text-red-400 text-sm"},z={key:0,class:"text-red-600 dark:text-red-400 text-sm"},Q={class:"col-span-full"},W={class:"flex items-center justify-between"},Z=["disabled"],A={key:0,class:"flex items-center"},G={key:1,class:"flex"},H={__name:"Create",setup(J){const l=P().props,y=w(!1),m=w(!1),r=h({propertyName:"",totalUnits:"",city:"",waterRate:"",electricityRate:"",mpesaPaybill:"",mpesaTillNumber:"",penaltyPercentage:"",streetName:"",paymentInstructions:"",errors:{}});U(()=>{l.property&&(m.value=!0,r.propertyName=l.property.propertyName,r.totalUnits=l.property.totalUnits,r.city=l.property.city,r.waterRate=l.property.waterRate,r.electricityRate=l.property.electricityRate,r.mpesaPaybill=l.property.mpesaPaybill,r.mpesaTillNumber=l.property.mpesaTillNumber,r.penaltyPercentage=l.property.penaltyPercentage,r.streetName=l.property.streetName,r.paymentInstructions=l.property.paymentInstructions)});const v=async()=>{y.value=!0,r.errors={};try{m.value?await r.put(route("properties.update",l.property.id)):await r.post(route("properties.store"))}catch(g){console.error(g),r.errors=g.response.data.errors||{}}finally{y.value=!1}};return(g,e)=>{const N=R("app-layout");return d(),i(V,null,[b(a(C),{title:"Create/Edit Property"}),b(N,null,{default:E(()=>{var x,f,k;return[t("div",S,[t("div",q,[t("h2",B,p(m.value?"Edit Property":"Create Property"),1),t("form",{onSubmit:T(v,["prevent"])},[t("div",F,[t("div",null,[e[10]||(e[10]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"propertyName"},[u(" Property Name "),t("span",{class:"text-red-500"},"*")],-1)),s(t("input",{"onUpdate:modelValue":e[0]||(e[0]=o=>a(r).propertyName=o),type:"text",id:"propertyName",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter property name",required:""},null,512),[[n,a(r).propertyName]]),(x=a(r).errors)!=null&&x.propertyName?(d(),i("div",D,p(a(r).errors.propertyName),1)):c("",!0)]),t("div",null,[e[11]||(e[11]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"totalUnits"},[u(" Total Units "),t("span",{class:"text-red-500"},"*")],-1)),s(t("input",{"onUpdate:modelValue":e[1]||(e[1]=o=>a(r).totalUnits=o),type:"number",id:"totalUnits",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter total units",required:"",min:"1"},null,512),[[n,a(r).totalUnits]]),(f=a(r).errors)!=null&&f.totalUnits?(d(),i("div",j,p(a(r).errors.totalUnits),1)):c("",!0)]),t("div",null,[e[12]||(e[12]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"city"},[u(" City "),t("span",{class:"text-red-500"},"*")],-1)),s(t("input",{"onUpdate:modelValue":e[2]||(e[2]=o=>a(r).city=o),type:"text",id:"city",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter city",required:""},null,512),[[n,a(r).city]]),(k=a(r).errors)!=null&&k.city?(d(),i("div",z,p(a(r).errors.city),1)):c("",!0)]),t("div",null,[e[13]||(e[13]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"streetName"}," Street Name ",-1)),s(t("input",{"onUpdate:modelValue":e[3]||(e[3]=o=>a(r).streetName=o),type:"text",id:"streetName",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter street name"},null,512),[[n,a(r).streetName]])]),t("div",null,[e[14]||(e[14]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"waterRate"}," Water Rate (per unit) ",-1)),s(t("input",{"onUpdate:modelValue":e[4]||(e[4]=o=>a(r).waterRate=o),type:"number",id:"waterRate",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter water rate"},null,512),[[n,a(r).waterRate]])]),t("div",null,[e[15]||(e[15]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"electricityRate"}," Electricity Rate (per unit) ",-1)),s(t("input",{"onUpdate:modelValue":e[5]||(e[5]=o=>a(r).electricityRate=o),type:"number",id:"electricityRate",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter electricity rate"},null,512),[[n,a(r).electricityRate]])]),t("div",null,[e[16]||(e[16]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"mpesaPaybill"}," M-Pesa Paybill ",-1)),s(t("input",{"onUpdate:modelValue":e[6]||(e[6]=o=>a(r).mpesaPaybill=o),type:"text",id:"mpesaPaybill",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter M-Pesa paybill number"},null,512),[[n,a(r).mpesaPaybill]])]),t("div",null,[e[17]||(e[17]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"mpesaTillNumber"}," M-Pesa Till Number ",-1)),s(t("input",{"onUpdate:modelValue":e[7]||(e[7]=o=>a(r).mpesaTillNumber=o),type:"text",id:"mpesaTillNumber",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter M-Pesa till number"},null,512),[[n,a(r).mpesaTillNumber]])]),t("div",null,[e[18]||(e[18]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"penaltyPercentage"}," Penalty Percentage (%) ",-1)),s(t("input",{"onUpdate:modelValue":e[8]||(e[8]=o=>a(r).penaltyPercentage=o),type:"number",id:"penaltyPercentage",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter penalty percentage"},null,512),[[n,a(r).penaltyPercentage]])]),t("div",Q,[e[19]||(e[19]=t("label",{class:"block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2",for:"paymentInstructions"}," Payment Instructions ",-1)),s(t("textarea",{"onUpdate:modelValue":e[9]||(e[9]=o=>a(r).paymentInstructions=o),id:"paymentInstructions",class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline",placeholder:"Enter payment instructions"},null,512),[[n,a(r).paymentInstructions]])])]),t("div",W,[t("button",{type:"submit",class:"bg-blue-500 dark:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-600 dark:hover:bg-blue-700",disabled:y.value},[y.value?(d(),i("span",A,e[20]||(e[20]=[t("svg",{class:"animate-spin h-5 w-5 mr-2",viewBox:"0 0 24 24"},[t("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),t("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8v4a4 4 0 100 8v4a8 8 0 01-8-8z"})],-1),u(" Saving... ")]))):(d(),i("span",G,[b(a(I),{class:"w-5 h-5 mr-2"}),e[21]||(e[21]=u()),t("span",null,p(m.value?"Update Property":"Create Property"),1)]))],8,Z)])],32)])])]}),_:1})],64)}}},X=M(H,[["__scopeId","data-v-30f990d8"]]);export{X as default};