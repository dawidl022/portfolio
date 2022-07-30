UPDATE users SET admin = 1 WHERE id = 1;

INSERT INTO posts VALUES(
    1, 1, "First blog post", "first-blog-post",
    "<p>
        Yes, I have decided to start my very own blog. I thought it would be a
        great idea to try and write about the things I learn to better solidify
        the concepts in my brain. It will also be a great opportunity to work on
        my soft (writing) skills, as they are also very very important and would
        allow me to convey my ideas to others better.
    </p>
    <p>
        It may be a while before actual contentful posts start appearing from
        me, so for now I'm treating the blog page as a proof of concept.
    </p>",
    "2022-01-28 11:34:29",
    "2022-01-28 11:34:29"
);

INSERT INTO votes (post_id) VALUES(1);

INSERT INTO posts VALUES(
    2, 1, "Personal website released", "personal-website-released",
    "<p>
        As part of the Fundamentals of Web Technology module exciting
        mini-project, the time has come to release a personal website. On this
        site, you will find a lot of information about what makes me stand out
        from the crowd. I do hope you like the styling.
    </p>
    <p>
        Feel free to leave any suggestion in the comments.
    </p>",
    "2022-03-03 14:51:12",
    "2022-03-03 14:51:12"
);

INSERT INTO votes (post_id) VALUES(2);
