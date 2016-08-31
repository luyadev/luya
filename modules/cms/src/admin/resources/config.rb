Encoding.default_external = 'utf-8'

require 'autoprefixer-rails'

http_path = "/"

css_dir = "css"
sass_dir = "scss"

output_style = :compressed # or :nested or :compact or :expanded
relative_assets = true
line_comments = false

on_stylesheet_saved do |file|
    css = File.read(file)
    map = file + '.map'

    if File.exists? map
        result = AutoprefixerRails.process(css,
            from: file,
            to:   file,
            map:  { prev: File.read(map), inline: false }
        )
        File.open(file, 'w') { |io| io << result.css }
        File.open(map,  'w') { |io| io << result.map }
    else
        File.open(file, 'w') { |io| io << AutoprefixerRails.process(css) }
    end
end