import{T as c,h as g,o as a,c as p,w as o,a as i,u as t,Z as y,b as r,f as k,g as x,d as n,n as v,k as b,e as h}from"./app-Cd6mMTGJ.js";import{_}from"./GuestLayout-DaPDuwF8.js";import{P as w}from"./PrimaryButton-eLin425z.js";/* empty css            */import"./_plugin-vue_export-helper-DlAUqK2U.js";const V={key:0,class:"mb-4 text-sm font-medium text-green-600 dark:text-green-400"},B={class:"mt-4 flex items-center justify-between"},j={__name:"VerifyEmail",props:{status:{type:String}},setup(d){const u=d,s=c({}),l=()=>{s.post(route("verification.send"))},f=g(()=>u.status==="verification-link-sent");return(m,e)=>(a(),p(_,null,{default:o(()=>[i(t(y),{title:"Email Verification"}),e[2]||(e[2]=r("div",{class:"mb-4 text-sm text-gray-600 dark:text-gray-400"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1)),f.value?(a(),k("div",V," A new verification link has been sent to the email address you provided during registration. ")):x("",!0),r("form",{onSubmit:h(l,["prevent"])},[r("div",B,[i(w,{class:v({"opacity-25":t(s).processing}),disabled:t(s).processing},{default:o(()=>e[0]||(e[0]=[n(" Resend Verification Email ")])),_:1},8,["class","disabled"]),i(t(b),{href:m.route("logout"),method:"post",as:"button",class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"},{default:o(()=>e[1]||(e[1]=[n("Log Out")])),_:1},8,["href"])])],32)]),_:1}))}};export{j as default};
