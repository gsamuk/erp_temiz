(()=>{var t=new Shepherd.Tour({defaultStepOptions:{cancelIcon:{enabled:!0},classes:"shadow-md bg-purple-dark",scrollTo:{behavior:"smooth",block:"center"}},useModalOverlay:{enabled:!0}});t.addStep({title:"Welcome Back !",text:"This is Step 1",attachTo:{element:"#logo-tour",on:"bottom"},buttons:[{text:"Next",classes:"btn btn-success",action:t.next}]}),t.addStep({title:"Register your account",text:"Get your Free Velzon account now.",attachTo:{element:"#register-tour",on:"bottom"},buttons:[{text:"Back",classes:"btn btn-light",action:t.back},{text:"Next",classes:"btn btn-success",action:t.next}]}),t.addStep({title:"Login your account",text:"Sign in to continue to Velzon.",attachTo:{element:"#login-tour",on:"bottom"},buttons:[{text:"Back",classes:"btn btn-light",action:t.back},{text:"Next",classes:"btn btn-success",action:t.next}]}),t.addStep({title:"Get yout Product",text:"Sign in to continue to Velzon.",attachTo:{element:"#getproduct-tour",on:"bottom"},buttons:[{text:"Back",classes:"btn btn-light",action:t.back},{text:"Next",classes:"btn btn-success",action:t.next}]}),t.addStep({title:"Thank you !",text:"Sign in to continue to Velzon.",attachTo:{element:"#thankyou-tour",on:"bottom"},buttons:[{text:"Back",classes:"btn btn-light",action:t.back},{text:"Thank you !",classes:"btn btn-primary",action:t.complete}]}),t.start()})();