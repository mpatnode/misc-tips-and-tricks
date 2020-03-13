//
// Binary trees are already defined with this interface:
// template<typename T>
// struct Tree {
//   Tree(const T &v) : value(v), left(nullptr), right(nullptr) {}
//   T value;
//   Tree *left;
//   Tree *right;
// };
typedef std::pair<Tree<int>*, Tree<int>*> TreePair;

TreePair find(Tree<int> *p, Tree<int> * t, int q) {
    if (!t || t->value == q) {
        return std::make_pair(p, t);
    }
    else if (q < t->value && t->left) {
        return find(t, t->left, q);
    }
    else if (q > t->value && t->right) {
        return find(t, t->right, q);
    }
    else {
        Tree<int> *dumb = NULL;
        return std::make_pair(t, dumb);
    }
}

Tree<int> * findAndDetachLargestRight(Tree<int> * t) {
    if (!t->right) {
        return NULL;
    }
    
    Tree<int> *ret = findAndDetachLargestRight(t->right);

    if (!ret) {
        ret = t->right;
        t->right = t->right->left;
    }

    return ret;
}
Tree<int> * removeFromBST(Tree<int> *t, int q) {
    TreePair tp = find(NULL, t, q);
    auto[target, parent] = tp;

    cout << "Find: " << q << " Target: " << target << " Parent: " << parent << endl;
    if (!target) {
        return t;
    }
    cout << "Target value: " << t->value << endl;

    if (target->left) {
        if (auto replacement = findAndDetachLargestRight(target->left)) {
            target->value = replacement->value;
        }
        else {
            target->value = target->left->value;
            target->left = target->left->left;
        }
    }
    else if (target->right) {
        target->value = target->right->value;
        target->left = target->right->left;
        target->right = target->right->right;
    }
    else if (parent) {
        if (parent->left == target) {
            parent->left = NULL;
        }
        else {
            parent->right = NULL;
        }
    }
    else {
        t = NULL;
    }
    return t;
}


Tree<int> * deleteFromBST(Tree<int> * t, std::vector<int> queries) {

    for (int q: queries) {
        t = removeFromBST(t, q);
    }

    return t;
}

