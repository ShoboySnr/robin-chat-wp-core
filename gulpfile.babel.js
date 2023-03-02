require('dotenv').config();
import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import gulpSass from 'gulp-sass';
import devSass from 'sass';
const sass = gulpSass(devSass);
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import autoprefixer from 'autoprefixer';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from 'browser-sync';
import zip from "gulp-zip";
import info from "./package.json";
import replace from "gulp-replace";
import wpPot from "gulp-wp-pot";


const PRODUCTION = yargs.argv.prod;
const server = browserSync.create();

export const serve = done => {
    server.init({
        proxy: process.env.proxy_url
    });
    done();
}

export const reload = done => {
    server.reload();
    done();
}

export const styles = () => {
    return src(['src/assets/scss/bundle.scss', 'src/assets/scss/bundle-admin.scss'])
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility: 'ie8'})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(dest('src/dist/css'))
        .pipe(server.stream());
}

export const images = () => {
    return src('src/assets/images/**/*.{jpg,jpeg,png,svg,gif}')
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest('src/dist/images'));
}

export const scripts = () => {
    return src(['src/assets/js/bundle.js', 'src/assets/js/bundle-admin.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: []
                            }
                        }
                    }
                ]
            },
            mode: PRODUCTION ? 'production' : 'development',
            devtool: !PRODUCTION ? 'inline-source-map' : false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            }
        }))
        .pipe(dest('src/dist/js'));
}

export const watchForChanges = () => {
    watch('src/assets/scss/**/*.scss', styles);
    watch('src/assets/images/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(['src/assets/**/*','!src/{images,js,scss}','!src/assets/{images,js,scss}/**/*'], series(copy, reload));
    watch('src/assets/js/**/*.js', series(scripts, reload));
    watch("**/*.php", reload);
}

export const copy = () => {
    return src(['src/assets/**/*','!src/assets/{images,js,scss}','!src/assets/{images,js,scss}/**/*'])
        .pipe(dest('src/dist'));
}

// export const compress = () => {
//     return src([
//         "**/*",
//         "!node_modules{,/**}",
//         "!bundled{,/**}",
//         "!.gitignore"
//     ])
//         .pipe(
//             gulpif(
//                 file => file.relative.split(".").pop() !== "zip",
//                 replace("_themename", info.name)
//             )
//         )
//         .pipe(zip(`${info.name}.zip`))
//         .pipe(dest('bundled'));
// };

export const pot = () => {
    return src("**/*.php")
        .pipe(
            wpPot({
                domain: "_themename",
                package: info.name
            })
        )
        .pipe(dest(`languages/${info.name}.pot`));
};

export const clean = () => del(['src/dist']);

export const dev = series(clean, parallel(styles, images, copy, scripts), serve, watchForChanges);

export const build = series(clean, parallel(styles, images, copy, scripts), pot);

export default dev;

