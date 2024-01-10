acf.add_filter('color_picker_args', function( args, $field ){
    
    // do something to args
    args.palettes = ['#5ee8bf', '#2f353e', '#f55e4f']
    
    
    // return
    return args;
            
});