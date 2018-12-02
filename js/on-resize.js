// https://github.com/louisremi/jquery-smartresize#minimalist-standalone-version
// debulked onresize handler
function on_resize(c,t){onresize=function(){clearTimeout(t);t=setTimeout(c,100)};return c};
